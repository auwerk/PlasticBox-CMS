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

class Version {
	public static $year		= 2011;
	public static $month	= 11;
	public static $patch	= 2;
	
	public static function getString() {
		return self::$year.".".self::$month.".".self::$patch;
	}
	
	public static function getHTML() {
		return "<div id=\"pb-version\">PlasticBox Web Framework version ".
			self::getString()."<br />Copyright (C) PlasticBox Dev Team</div>";
	}
	
	public static function getGenerator() {
		return "PlasticBox Web Framework version ".self::getString();
	}
}