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

class Database {
	private static $_instance = null;
	public static function getInstance() {
		if (self::$_instance == null) {
			$dbClassName = "Database_".Configuration_CMS::$_dbType;
			self::$_instance = new $dbClassName();
		}
		return self::$_instance;
	}
}

?>