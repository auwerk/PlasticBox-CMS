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

define("_NOTRIM",1);
define("_ALLOWHTML",2);
define("_ALLOWRAW",4);

final class Request {

	public static function getParam($arr,$name,$def=null,$mask=0) {
		$noHtmlFilter	= null;
		$safeHtmlFilter	= null;

		$return = null;
		if (isset($arr[$name])) {
			$return = $arr[$name];
			if (is_string($return)) {
				// trim data
				if (!($mask&_NOTRIM)) {
					$return = trim($return);
				}
				if ($mask&_ALLOWRAW) {
					// do nothing
				}
				else if ($mask&_ALLOWHTML) {
					// do nothing - compatibility mode
				}
				else {
					// send to inputfilter
					if (is_null($noHtmlFilter)) {
						$noHtmlFilter = new InputFilter(/*$tags,$attr,$tag_method,$attr_method,$xss_auto*/);
					}
					$return = $noHtmlFilter->process($return);
					// if value is defined and default value is numeric set variable type to integer
					if (empty($return) && is_numeric($def)) {
						$return = intval($return);
					}
				}
				// account for magic quotes setting
				if (!get_magic_quotes_gpc() && $mask!=7) {
					$return = addslashes($return);
				}
			}
			return $return;
		}
		else {
			return $def;
		}
	}

	public static function get($key,$defaultValue="") {
		return self::getParam($_REQUEST,$key,$defaultValue);
	}

	public static function getCookie($name,$defaultValue="") {
		return self::getParam($_COOKIE,$name,$defaultValue);
	}

	public static function getInt($key,$defaultValue=0) {
		return intval(self::get($key,$defaultValue));
	}
}

?>