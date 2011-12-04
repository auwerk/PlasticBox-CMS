<?php

/*
* PlasticBox web framework for PHP
* Copyright (C) PlasticBox Dev Team
*
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License version 2 as
* published by the Free Software Foundation.
* 
* Author: Alexander Yukhnenko
* 
*/

defined('_PB_VALID') or die("Restricted access");

//
// Class loader (uses PHP 5.3 SPL mechanism)
//
class Loader {
	public static function loadClass($className) {
		$scriptPath = PATH_CLASSES.DS.$className.".php";
		if (file_exists($scriptPath)) {
			require_once $scriptPath;
			if (!class_exists($className,false)) die("Unable to load class: ".$className);
		}
		else die("No script for class: ".$className);
	}
	
	public static function activate() {
		return spl_autoload_register("Loader::loadClass");
	}
}

?>