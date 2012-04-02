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
 * Abstract URL class
 */
abstract class Twui_Url
{

	/**
	 * Return the application URL.
	 * @param $full Full URL
	 * @return String.
	 */
	public static function app_url ( $full = false )
	{
		return self::base_url($full).'index.php/';
	}

	/**
	 * Return the base URL.
	 * @param $full Full URL
	 * @return String.
	 */
	public static function base_url ( $full = false )
	{
		global $_SERVER;
		if ($full)
		{
			$url = Twui::config('app_url', false);
			if ($url !== false)
			{
				return $url;
			}
		}
		else
		{
			$url = Twui::config('base_url', false);
			if ($url !== false)
			{
				return $url;
			}
		}
		$host = $_SERVER['SERVER_NAME'];
		$port = $_SERVER['SERVER_PORT'];
		$cont = dirname($_SERVER['SCRIPT_NAME']) . '/';
		$url = 'http' . ($port == 443 ? 's' : '') . '://'
			. $host . ($port != 80 && $port != 443 ? ':'.$port : '')
			. $cont;
		return $url;
	}

	/**
	 * Return the current URL.
	 * @return String.
	 */
	public static function current_url ()
	{
		global $_SERVER;
		$host = $_SERVER['SERVER_NAME'];
		$port = $_SERVER['SERVER_PORT'];
		$cont = $_SERVER['REQUEST_URI'];
		$url = 'http' . ($port == 443 ? 's' : '') . '://'
			. $host . ($port != 80 && $port != 443 ? ':'.$port : '')
			. $cont;
		return $url;
	}

	/**
	 * Return the referrer URL.
	 * @return String.
	 */
	public static function referrer_url ()
	{
		global $_SERVER;
		return $_SERVER['HTTP_REFERRER'];
	}

}

