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
 * Core class
 */
abstract class Twui_Core
{

	/**
	 * Global configuration array
	 * @var array
	 */
	public static $config = null;

	/**
	 * Auto load class if needed.
	 * @param $class A classname
	 * @return boolean
	 */
	public static function autoload ( $class )
	{
		$path = str_replace('_', DIRECTORY_SEPARATOR, strtolower($class)).'.php';
		if (is_file(CLASSPATH.$path))
		{
			require(CLASSPATH.$path);
			return true;
		}
		throw new ErrorException('Class not found: '.$class);
	}

	/**
	 * Retrieve configuration element.
	 * @param $param Parameter name
	 * @param $default Default value if not found
	 * @return string
	 */
	public static function config ( $param, $default = null )
	{
		if (is_null(self::$config))
		{
			self::$config = include(CONFPATH.'config.php');
		}
		if (is_array(self::$config) && isset(self::$config[$param]))
		{
			return self::$config[$param];
		}
		return $default;
	}

	/**
	 * Dispatcher
	 */
	public static function dispatch ()
	{
		global $_SERVER;

		// Prepare variables
		$action = 'index';
		$controller = 'index';
		$path = '/';

		// Get path info from server
		if (isset($_SERVER['PATH_INFO']))
		{
			$path = $_SERVER["PATH_INFO"];
		}

		// Allow only leters, numbers and slashes
		if (preg_match('/^[\p{L}\/\d]++$/uD', $path) == 0)
		{
			display_error('Invalid URL');
		}

		// Try to found valid controller class and corresponding action.
		$tokens = explode('/', $path);
		$tokens_count = count($tokens);
		if ($tokens_count > 1 && !empty($tokens[1]))
		{
			$controller = '';
			for ($i = 1; $i < $tokens_count && $action == 'index'; $i++)
			{
				$token = strtolower($tokens[$i]);
				$obj = Controller::factory($controller);
				if (!is_null($obj) && $obj->hasAction($token))
				{
					$action = $token;
				}
				else
				{
					$controller .= ($i == 1 ? '' : '_').$token;
				}
			}
		}

		// Execute requested controller and action
		try
		{
			$controller = Controller::factory($controller);
			if (is_null($controller))
			{
				throw new Exception('Invalid URL');
			}
			$controller->request(new Request())->action($action)->execute();
		}
		catch (Exception $e)
		{
			display_error($e->getMessage());
		}
	}

}

