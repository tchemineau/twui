<?php
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
 * Define application directory.
 */
define('APPPATH', ROOTPATH.'application'.DIRECTORY_SEPARATOR);

/**
 * Define configuration directory.
 */
define('CONFPATH', APPPATH.'config'.DIRECTORY_SEPARATOR);

/**
 * Define classes directory.
 */
define('CLASSPATH', APPPATH.'classes'.DIRECTORY_SEPARATOR);

/**
 * Define data directory.
 */
define('DATAPATH', ROOTPATH.'data'.DIRECTORY_SEPARATOR);

/**
 * Define library directory.
 */
define ('LIBPATH', APPPATH.'libraries'.DIRECTORY_SEPARATOR);

/**
 * Define scripts directory.
 */
define('SCRIPTPATH', APPPATH.'scripts'.DIRECTORY_SEPARATOR);

/**
 * Define vendors directory.
 */
define('THIRDPATH', LIBPATH.'third'.DIRECTORY_SEPARATOR);

/**
 * Define views directory.
 */
define('VIEWPATH', APPPATH.'views'.DIRECTORY_SEPARATOR);

/**
 * Load main classes and functions.
 */
require(CLASSPATH.'twui/core.php');
require(CLASSPATH.'twui.php');
require(LIBPATH.'function.php');

/**
 * Register class autoloader.
 */
spl_autoload_register(array('Twui', 'autoload'));

/**
 * Starting session managment.
 */
session_start();

