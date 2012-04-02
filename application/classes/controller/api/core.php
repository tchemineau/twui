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
 * Main API controller.
 */
class Controller_Api_Core extends Controller_Api
{

	/**
	 * Is error.
	 * @var boolean
	 */
	private $_error = false;

	/**
	 * Output format.
	 * @var String
	 */
	private $_format = 'json';

	/**
	 * Global response attribute.
	 * @var mixed
	 */
	private $_response = false;

	/**
	 * Perform some verifications on returned status.
	 */
	public function after ()
	{
		if ($this->_error === false)
		{
			$mimetype = 'text/html';
			$response = $this->_response;
			switch($this->_format)
			{
				case 'json':
					$mimetype = 'application/json';
					$response = json_encode($response);
					break;
			}
			header('Content-Type', $mimetype);
			echo $response;
		}
		else
		{
			header('Status: '.$this->_error, true, $this->_error);
		}
	}

	/**
	 * Using API required a loggged in user.
	 */
	public function before ()
	{
		$format = $this->request()->param('format');
		if ($format !== false)
		{
			$this->_format = $format;
		}
	}

	/**
	 * Set error.
	 * @param $error HTTP return code.
	 */
	public function error ( $status = '400' )
	{
		$this->_error = $status;
		return $this;
	}

	/**
	 * Set output format.
	 * @param $format Possible values are: 'json', 'php'.
	 * @return Controller_Api_Core
	 */
	public function format ( $format = 'json' )
	{
		switch(strtolower($format))
		{
			case 'json':
			case 'php':
				$this->_format = $format;
				break;
		}
		return $this;
	}

	/**
	 * Set response.
	 * @param $response mixed
	 * @return Controller_Api_Core
	 */
	public function response ( $response = false )
	{
		$this->_response = $response;
		return $this;
	}

}

