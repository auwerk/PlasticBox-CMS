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

final class Path {
	
	public static function getFramework($subPath) {
		return PATH_FRAMEWORK.DS.$subPath;
	}
	
	public static function getSite($subPath) {
		return PATH_SITES.DS.Configuration_CMS::$_siteName.DS.$subPath;
	}
}

?>