<?php

	/*
	 * Create a file named myconfs.php in the same
	 * directory and set the following to match
	 * your environment.
	 *
	 * $rootPath = "/var/www/orangehrm";
	 * $webPath = "http://localhost/orangehrm";
	 *
	 */

	require 'myconf.php';

	echo $rootPath;

	if (!defined('ROOT_PATH')) {
	    define('ROOT_PATH', $rootPath);
	}

	if (!defined('WPATH')) {
	    define('WPATH', $webPath);
	}

?>
