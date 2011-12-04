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

final class ArrayHelper {
	
	public static function getKeyValue($key,$array,$defaultValue=null) {
		if (array_key_exists($key,$array)) return $array[$key];
		else return $defaultValue;
	}
	
}