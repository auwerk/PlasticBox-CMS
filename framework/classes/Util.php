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

final class Util {

	public static function fatalError($errText,$errCode="") {
		ob_end_clean();
		echo "
		<html>
			<head>
				<title>Fatal error</title>
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
			</head>
			<body>
				<h1>Fatal error</h1>
				<p>$errText</p>
			</body>
		</html>";
		exit;
	}

	public static function redirect($url) {
		header("Location: $url");
	}

	public static function isFilled($arr) {
		if (!is_array($arr)) return false;
		if (count($arr) < 1) return false;
		return true;
	}

	public static function getProperty($haystack,$key,$defaultValue="") {
		if (is_object($haystack)) {
			if (isset($haystack->$key)) return $haystack->$key;
			else return $defaultValue;
		}
		else if (is_array($haystack)) {
			if (array_key_exists($key,$haystack)) return $haystack[$key];
			else return $defaultValue;
		}
		else return $defaultValue;
	}

	public static function showArray($array,$name="",$nested=false) {
		if (!$nested) echo "<table>";
		if (!is_array($array) && !is_object($array)) {
			echo "<tr>";
			echo "<td>[$name]</td><td>=>&nbsp;$array&nbsp;<i>(".gettype($array).")</i></td>";
			echo "</tr>";
		}
		else {
			echo "<tr><td colspan=\"2\">--&nbsp;$name&nbsp;(array)&nbsp;--</td></tr>";
			if (is_object($array)) $array = get_object_vars($array);
			foreach ($array as $key=>$value) {
				self::showArray($value,$key,true);
			}
		}
		if (!$nested) echo "</table>";
	}

	public static function getSiteUploadPath($subPath="") {
		$upPath = Registry::getInstance()->get("siteDirectory").DS."upload";
		if ($subPath) $upPath .= DS.$subPath;
		return $upPath;
	}

	public static function getSiteUploadPathWeb($subPath="") {
		$upPath = Registry::getInstance()->get("sitePathWeb")."/upload";
		if ($subPath) $upPath .= "/".$subPath;
		return $upPath;
	}

	public static function stripExtension($fileName) {
		$fnp = explode(".",$fileName);
		return $fnp[1];
	}

}

?>