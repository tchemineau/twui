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
 * Abstract class for all controllers
 */
abstract class Twui_Controller
{

	/**
	 * Current controller instance.
	 * @var Controller
	 */
	public static $controller = null;

	/**
	 * Controller action.
	 * @var String
	 */
	private $_action = null;

	/**
	 * This controller name.
	 * @var String
	 */
	private $_name = null;

	/**
	 * Request.
	 * @var Request
	 */
	private $_request = null;

	/**
	 * Get or set action.
	 * @param $action Action to call.
	 * @return string|Controller
	 */
	public function action ( $action = null )
	{
		if (is_null($action))
		{
			return $this->_action;
		}
		$this->_action = $action;
		return $this;
	}

	/**
	 * Main action.
	 */
	public function action_index ()
	{
	}

	/**
	 * Call after any action.
	 */
	public function after ()
	{
	}

	/**
	 * Call before any action.
	 */
	public function before ()
	{
	}

	/**
	 * Return current controller name or instance (the last one).
	 * @param $name True to return only name (default: false)
	 * @return Controller
	 */
	public static function current ( $name = false )
	{
		if ($name && !is_null(self::$controller))
		{
			return self::$controller->name();
		}
		return self::$controller;
	}

	/**
	 * Execute action.
	 */
	public function execute ()
	{
		$this->before();
		$action = 'action_'.$this->action();
		$this->$action();
		$this->after();
	}

	/**
	 * Return a controller
	 * @param $controller A controller to load.
	 * @return Controller
	 */
	public static function factory ( $controller )
	{
		$name = 'Controller_'.ucwords(strtolower($controller));
		try
		{
			self::$controller = new $name();
			self::$controller->name(strtolower($controller));
			return self::$controller;
		}
		catch (Exception $e)
		{
			return null;
		}
	}

	/**
	 * Test if this controller has the given action.
	 * @param $action An action name to test.
	 * @return boolean
	 */
	public function hasAction ( $action )
	{
		return method_exists($this, 'action_'.$action);
	}

	/**
	 * Set or get controller name.
	 * @param $name Controller name.
	 * @return String
	 */
	public function name ( $name = null )
	{
		if (is_null($name))
		{
			return $this->_name;
		}
		$this->_name = $name;
		return $this;
	}

	/**
	 * Set or get request.
	 * @param $request A request object.
	 * @return Request|Controller
	 */
	public function request ( $request = null )
	{
		if (is_null($request))
		{
			return $this->_request;
		}
		$this->_request = $request;
		return $this;
	}

}

