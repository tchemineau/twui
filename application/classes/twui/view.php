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
 * Class that will render a view.
 */
abstract class Twui_View
{

	/**
	 * Data that could be use by this view.
	 * @var array
	 */
	private $_data;

	/**
	 * The file attached to this view.
	 * @var String.
	 */
	private $_file;

	/**
	 * Render the template.
	 */
	public function __toString ()
	{
		$content = '';
		try
		{
			ob_end_clean();
			foreach ($this->_data as $key => $value)
			{
				$$key = $value;
			}
			ob_start();
			include($this->_file);
			$content = ob_get_contents();
			ob_end_clean();
		}
		catch (Exception $e)
		{
			file_put_contents('php://stderr', $e);
		}
		return $content;
	}

	/**
	 * Bind a variable to a value into the view.
	 * @param $key A key
	 * @param $value A value
	 * @return View
	 */
	public function bind ( $key, $value = '' )
	{
		if (is_null($this->_data) || !is_array($this->_data))
		{
			$this->_data = array();
		}
		$this->_data[$key] = $value;
		return $this;
	}

	/**
	 * Bind several variables by reading an associative array.
	 * @param $vars An associative array.
	 * @return View
	 */
	public function bindall ( $vars )
	{
		foreach ($vars as $key => $value )
		{
			$this->bind($key, $value);
		}
		return $this;
	}

	/**
	 * Return a view.
	 * @param $view A view to load.
	 * @return View
	 */
	public static function factory ( $view )
	{
		$v = new View();
		$v->set_file(VIEWPATH.$view.'.php');
		$v->set_data(array());
		return $v;
	}

	/**
	 * Render this view.
	 * @return String
	 */
	public function render ()
	{
		echo $this;
	}

	/**
	 * Set data.
	 * @param $data A array
	 * @return View
	 */
	public function set_data ( $data )
	{
		$this->_data = $data;
		return $this;
	}

	/**
	 * Set file.
	 * @param $file The new file to attach to this view.
	 * @return View
	 */
	public function set_file ( $file )
	{
		$this->_file = $file;
		return $this;
	}

}

