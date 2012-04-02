#!/bin/bash
#
# This is the tsung service. It will handle load test requests.
#
# Twui
# Copyright (C) 2012  Thomas Chemineau <thomas.chemineau@gmail.com>
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program. If not, see <http://www.gnu.org/licenses/>.
#

# -----------------------------------------------------------------------------
# AUTO CONFIGURATION
# -----------------------------------------------------------------------------

DIRNAME="$(dirname "$0")"
SCRIPTNAME="$(basename "$0")"
FILENAME="${SCRIPTNAME%.*}"
FILEPATH="$(cd $DIRNAME 2>/dev/null && /bin/pwd)/$SCRIPTNAME"
ROOTDIR="$(dirname "$(dirname "$(dirname "$FILEPATH")")")"
SYSDIR="$ROOTDIR/system"
CONFDIR="$SYSDIR/etc"
DATADIR="$ROOTDIR/data"
TOOLDIR="$SYSDIR/bin"

# -----------------------------------------------------------------------------
# LOAD AND SET PARAMETERS
# -----------------------------------------------------------------------------

# Load configuration file
[ -f "$CONFDIR"/$FILENAME.conf ] && . "$CONFDIR"/$FILENAME.conf

# Set default values
[ -n "$DEBUG" ] || DEBUG="0"
[ -n "$INOTIFYIN" ] || INOTIFYIN="$DATADIR/$$.inotify"
[ -n "$INOTIFYDIR" ] || INOTIFYDIR="$DATADIR/spool"
[ -n "$PIDFILE" ] || PIDFILE="$DATADIR/$FILENAME.pid"
[ -n "$LOCKFILE" ] || LOCKFILE="$DATADIR/$FILENAME.lock"
[ -n "$LOGPRIORITY" ] || LOGPRIORITY="local5"

# -----------------------------------------------------------------------------
# INTERNAL PARAMETERS
# -----------------------------------------------------------------------------

_IDIR=
_IEVENT=
_IFILE=

# -----------------------------------------------------------------------------
# FUNCTIONS
# -----------------------------------------------------------------------------

# ----
# Start the daemon
#
DAEMON_START ()
{
  if [ -f "$LOCKFILE" ]; then
    LOG_MESSAGE info "$FILENAME is already started"
    return 1
  fi
  MONITOR_START
  if [ $? -ne 0 ]; then
    LOG_MESSAGE error "could not start $FILENAME monitor"
    return 1
  fi
  echo "$$" > $PIDFILE
  echo "$$" > $LOCKFILE
  LOG_MESSAGE info "start $FILENAME daemon ($$)"
  LOOP_ON_EVENTS
}

# ----
# Stop the daemon
#
DAEMON_STOP ()
{
  MONITOR_STOP
  if [ $? -ne 0 ]; then
    LOG_MESSAGE error "could not stop $FILENAME monitor"
    return 1
  fi
  rm -f $PIDFILE
  rm -f $LOCKFILE
  LOG_MESSAGE info "stop $FILENAME daemon ($$)"
  return 0
}

# ----
# Execute an event
#
EXEC_EVENT ()
{
  file="$_DIR/`echo $_FILE | sed -e 's!^/!!'`"
  case "$_EVENT" in
    # New request
    "CREATE")
      if [ ! -f $file ]; then
        return 1
      fi
      LOG_MESSAGE debug "new request $file"
      return $?
      ;;
    # Request finished
    "DELETE")
      LOG_MESSAGE debug "end request $file"
      return $?
      ;;
  esac
}

# ----
# Loop on events
#
LOOP_ON_EVENTS ()
{
  while [ 0 ]
  do
    READ_EVENT
    if [ $? -eq 0 ]; then
      LOG_MESSAGE debug "$_EVENT - $_DIR/$_FILE"
      EXEC_EVENT
      LOG_MESSAGE debug "event execution status = $?"
    fi
  done
}

# ----
# Start the monitor thread
#
MONITOR_START ()
{
  # Check inotify command
  local inotifywait="$(which inotifywait)"
  if [ -z "$inotifywait" ]; then
    LOG_MESSAGE error "could not find inotifywait command"
    return 1
  fi
  # Check if FIFO exists, if not auto-create it
  [ ! -p "$INOTIFYIN" ] && mkfifo "$INOTIFYIN" 2> /dev/null
  if [ ! -p "$INOTIFYIN" ]; then
    LOG_MESSAGE error "could not create input fifo '$INOTIFYIN'"
    return 1
  fi
  # Check if directory exists, if not auto-create it
  [ ! -d "$INOTIFYDIR" ] && mkdir -p "$INOTIFYDIR" 2> /dev/null
  if [ ! -d "$INOTIFYDIR" ]; then
    LOG_MESSAGE error "could not create input directory '$INOTIFYDIR'"
    return 1
  fi
  # Start inotify command
  $inotifywait -q -c -r -m -e create,delete $INOTIFYDIR > $INOTIFYIN &
  local err=$?
  local pid=$!
  if [ $err -eq 0 ]; then
    echo "$pid" > "$DATADIR"/"$FILENAME"-monitor.pid
  fi
  LOG_MESSAGE info "$FILENAME monitor started ($pid) = $err"
  return $err
}

# ----
# Stop the monitor thread
#
MONITOR_STOP ()
{
  if [ ! -f "$DATADIR"/"$FILENAME"-monitor.pid ]; then
    LOG_MESSAGE debug "$FILENAME monitor is already stopped"
    return 0
  fi
  local pid="$(cat "$DATADIR"/"$FILENAME"-monitor.pid)"
  local err=0
  LOG_MESSAGE debug "trying to stop $FILENAME monitor ($pid)"
  if [ -n "`ps -p $pid h`" ]; then
    kill -s TERM $pid > /dev/null 2>&1
    err=$?
    sleep 1
    if [ $err -ne 0 ]; then
      kill -s KILL $pid > /dev/null 2>&1
      err=$?
    fi
  fi
  if [ $err -eq 0 ]; then
    rm -f "$INOTIFYIN"
    rm -f "$DATADIR"/"$FILENAME"-monitor.pid
  fi
  LOG_MESSAGE info "$FILENAME monitor stopped ($pid) = $err"
  return $err
}

# ----
# Log message to syslog.
#
LOG_MESSAGE ()
{
  local logbin="$(which logger)"
  local loglvl="$1"
  shift
  if [ "$DEBUG" != "0" ]; then
    $logbin -f /dev/null -s -p $LOGPRIORITY.$loglvl -t "$SCRIPTNAME[$$]" -- "$*"
  else
    $logbin -p $LOGPRIORITY.$loglvl -t "$SCRIPTNAME[$$]" -- "$*"
  fi
}

# ----
# Read an event
#
READ_EVENT ()
{
  local myevent=
  read myevent < $INOTIFYIN
  if [ -n "$myevent" ]; then
    _DIR="`echo "$myevent" | cut -d ',' -f 1 | sed -e 's!/$!!'`"
    _EVENT="`echo "$myevent" | cut -d ',' -f 2`"
    _FILE="`echo "$myevent" | cut -d ',' -f 3`"
    return 0
  fi
  _DIR=
  _EVENT=
  _FILE=
  return 1
}

# ----
# Trap signals and stop the daemon
#
TRAP_SIGNALS ()
{
  DAEMON_STOP
  if [ $? -eq 0 ]; then
    exit 0
  fi
}

# -----------------------------------------------------------------------------
#  CHECKS
# -----------------------------------------------------------------------------

# Must be root to run this daemon
#if [ $(id -u) -ne 0 ]; then
#  LOG_MESSAGE error "$FILENAME requires root privileges"
#  exit 1
#fi

# Check data directory
if [ ! -w "$DATADIR" ]; then
  LOG_MESSAGE error "$DATADIR is not writable"
  exit 1
fi

# -----------------------------------------------------------------------------
#  MAIN
# -----------------------------------------------------------------------------

# Catch system signals
trap 'TRAP_SIGNALS' 1 2 3 4 5 6 7 8 10 12 13 14 15 20

# Start daemon
DAEMON_START

