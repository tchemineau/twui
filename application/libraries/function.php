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
 * Change the extension into a file path.
 * @param $path A valid path.
 * @param $extension The new extension.
 * @return String
 */
function change_path_extension ( $path, $extension )
{
	$parts = pathinfo($path);
	return $parts['dirname'].DIRECTORY_SEPARATOR.$parts['filename'].$extension;
}

/**
 * Display an error message and exit.
 * @param $msg An error message.
 */
function display_error ( $msg = '' )
{
	die($msg);
}

/**
 * Download a file.
 * @param $file Full path to the file to download.
 */
function download_file ( $file )
{
	if (is_file($file))
	{
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$ftype = finfo_file($finfo, $file);
		finfo_close($finfo);
		header('Expires: 0');
		header('Last-Modified: '.gmdate('D, d M Y H:i:s'). ' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');
		header('Content-type: '.$ftype);
		header('Content-length: '.filesize($file));
		header('Content-disposition: attachment; filename='.basename($file));
		readfile($file);
	}
	exit();
}

/**
 * Get a random password.
 * @param $length Length of the password.
 * @return String
 */
function get_random_password ( $length = 8 )
{
	$password = "";
	$possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
	$maxlength = strlen($possible);
	if ($length > $maxlength)
	{
		$length = $maxlength;
	}
	$i = 0;
	while ($i < $length)
	{
		$char = substr($possible, mt_rand(0, $maxlength-1), 1);
		if (!strstr($password, $char))
		{
			$password .= $char;
			$i++;
		}
	}
	return $password;
}

/**
 * Determine if supplied string is a valid md5 string
 * @param string $md5 String to validate
 * @return boolean
 */
function is_md5 ( $md5 )
{
    return !empty($md5) && preg_match('/^[a-f0-9]{32}$/', $md5);
}

