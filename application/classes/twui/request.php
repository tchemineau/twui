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
 * Abstract request class
 */
abstract class Twui_Request
{

	/**
	 * Request parameters.
	 * @var Array
	 */
	private $_params = array();

	/**
	 * Construct a new core controller.
	 */
	public function __construct ()
	{
		$this->_params = self::params();
	}

	/**
	 * Determine if this HTTP request is an ajax request.
	 * @return boolean
	 */
	public static function is_ajax ()
	{
		global $_SERVER;
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') ? true : false;
	}

	/**
	 * Function that retrieve one parameter.
	 * @param $param Parameter name.
	 * @param $default Default value if not found (false)
	 * @return string|boolean
	 */
	public function param ( $param, $default = false )
	{
		if (isset($this->_params[$param]))
		{
			return $this->_params[$param];
		}
		return $default;
	}

	/**
	 * Get unified request GET and POST parameters.
	 * POST parameters are preferred.
	 */
	public static function params ()
	{
		global $_GET, $_POST;

		// Prepare array that will store parameters.
		$params = array();

		// Check GET parameters first.
		if (isset($_GET))
		{
			$params = array_merge($params, $_GET);
		}

		// Check POST parameters.
		if (isset($_POST))
		{
			$params = array_merge($params, $_POST);
		}

		ksort($params);
		return $params;
	}

	/**
	 * Redirect to a particular URL.
	 * @param $url An URL to redirect to
	 */
	public static function redirect ( $url )
	{
		header('location: ' . $url);
		exit(0);
	}

}

