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

define("PBST_NONE",0);
define("PBST_VARCHAR",1);
define("PBST_INT",2);
define("PBST_TEXT",3);

final class Settings {
	private static $_instance = null;
	public static function getInstance() {
		if (self::$_instance == null) self::$_instance = new self();
		return self::$_instance;
	}

	private $_db 		= null;
	private $_settings	= array();

	private function __construct() {
		$this->_db = Database::getInstance();
		// Load all settings
		$query = "SELECT * FROM `settings`";
		$this->_db->setQuery($query);
		$this->_settings = $this->_db->loadObjectList("key");
	}

	public function get($key,$defaultValue=null) {
		$key = strtolower($key);
		if (array_key_exists($key,$this->_settings)) {
			switch ($this->_settings[$key]->type) {
				case PBST_INT:
					return intval($this->_settings[$key]->int_value);
					break;
				case PBST_TEXT:
					return strval($this->_settings[$key]->text_value);
					break;
				case PBST_VARCHAR:
				default:
					return strval($this->_settings[$key]->vc_value);
					break;
			}
		}
		else return $defaultValue;
	}
	
	public function set($key,$value=null) {
		$key = strtolower($key);
		$sType = $this->getType($key);
		if ($sType != PBST_NONE) {
			if ($sType == PBST_INT) $value = intval($value);
			$this->_settings[$key] = $value;
			// DB
			switch ($sType) {
				case PBST_INT: $dbField = "int_value"; break;
				case PBST_TEXT: $dbField = "text_value"; break;
				case PBST_VARCHAR: default: $dbField = "vc_value"; break;
			}
			$query = "UPDATE `settings` SET `$dbField`='$value' WHERE `key`='$key'";
			$this->_db->setQuery($query);
			$this->_db->query();
		}
		else Debugger::getInstance()->log("Settings key &quot;$key&quot; does not exist");
	}
	
	public function getType($key) {
		$key = strtolower($key);
		if (array_key_exists($key,$this->_settings)) {
			return $this->_settings[$key]->type; 
		}
		else return PBST_NONE;
	}
}