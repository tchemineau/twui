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
 * Controller that manages tests
 */
class Controller_Test extends Controller
{

	/**
	 * Create test.
	 */
	public function action_create ()
	{
		View::factory('test')->render();
	}

	/**
	 * Main action.
	 */
	public function action_index ()
	{
		$server = Server::factory();
		$status = array(
			'is_running' => $server->is_running()
		);
		$view = View::factory('test');
		$view->bind('status', $status);
		$view->render();
	}

	/**
	 * Play action.
	 */
	public function action_play ()
	{
		View::factory('test')->render();
	}

	/**
	 * Record action.
	 */
	public function action_record ()
	{
		View::factory('test')->render();
	}

}

