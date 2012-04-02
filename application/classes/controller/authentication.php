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
 * Class that will manage authentication
 */
class Controller_Authentication extends Controller
{

	/**
	 * Main action.
	 */
	public function action_index ()
	{
		global $_SESSION;

		// Prepare action data
		$error = false;
		$username = $this->request()->param('username');
		$password = $this->request()->param('password');

		// If data found, check them
		if ($username === false && $password === false)
		{
			$error = 'Authentication required';
		}

		// If data found, then try to authenticate
		if ($error === false)
		{
			$model = Model::factory('user');
			if (!$model->authenticate($username, $password))
			{
				$error = 'Authentication failed';
			}
			else
			{
				$_SESSION['user'] = $model->get($username);
			}
		}

		// Render final output.
		if ($error === false)
		{
			$this->check_and_redirect();
		}
		else
		{
			View::factory('authentication')->render();
		}
	}

	/**
	 * Do thing before.
	 */
	public function before ()
	{
		$this->check_and_redirect();
	}

	/**
	 * Check session existance.
	 */
	public function check_and_redirect ()
	{
		global $_SESSION;

		// Possible parameters
		$logout = $this->request()->param('logout');
		$url = $this->request()->param('url');

		// If user is logged in, then disconnect it if necessary
		if (isset($_SESSION['user']))
		{
			if ($logout !== false)
			{
				if (ini_get('session.use_cookies'))
				{
					$params = session_get_cookie_params();
					setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
				}
				session_destroy();
			}
			if ($url !== false)
			{
				$url = base64_decode($url);
			}
			else
			{
				$url = Url::base_url();
			}
			$this->request()->redirect($url);
		}
	}

}

