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
 * Model to manage a test.
 */
class Model_Test extends Model
{

	/**
	 * Add a particular test.
	 * @param $test A test identifier
	 * @param $data Test data
	 * @return boolean
	 */
	public function add ( $test, $data )
	{
		return false;
	}

	/**
	 * Delete a particular test.
	 * @param $test A test identifier
	 * @return boolean
	 */
	public function delete ( $test )
	{
		return false;
	}

	/**
	 * Retrieve a particular test.
	 * @param $test A test identifier
	 * @return Array
	 */
	public function get ( $test )
	{
		return array();
	}

	/**
	 * Get a list of available test.
	 * @return array
	 */
	public function get_all ()
	{
		return array();
	}

}

