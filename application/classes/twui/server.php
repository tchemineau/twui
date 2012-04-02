<?php defined('APPPATH') or die('No direct script access.');

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

/**
 * Class to manage Twui server
 */
abstract class Twui_Server
{

	/**
	 * Server lock file.
	 * @var String
	 */
	private $_lock = null;

	/**
	 * Spool directory.
	 * @var String
	 */
	private $_spool = null;

	/**
	 * Get a server object.
	 * @return Server
	 */
	public static function factory ()
	{
		$server = new Server();
		$server->lock(Twui::config('server_lock', DATAPATH.'twui-daemon.lock'));
		$server->spool(Twui::config('server_spool', DATAPATH.'spool'.DIRECTORY_SEPARATOR));
		return $server;
	}

	/**
	 * Check if the server is running or not.
	 * @return boolean
	 */
	public function is_running ()
	{
		return is_file($this->lock());
	}

	/**
	 * Set or get lock file.
	 * @param $lock A lock file.
	 * @return String|this
	 */
	public function lock ( $lock = null )
	{
		if (is_null($lock))
		{
			return $this->_lock;
		}
		$this->_lock = $lock;
		return $this;
	}

	/**
	 * Set or get spool directory.
	 * @param $spool A directory.
	 * @return String|this
	 */
	public function spool ( $spool = null )
	{
		if (is_null($spool))
		{
			return $this->_spool;
		}
		$this->_spool = $spool;
		return $this;
	}

}

