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

final class Registry {
	private static $_instance = null;
	public static function getInstance() {
		if (!self::$_instance) {
			self::$_instance = new self();
			Debugger::getInstance()->log("Registry created");
		}
		return self::$_instance;
	}
	
	private $_array = array();
	
	private function __construct() {
		//
	}
	
	public function set($key,$value=null) {
		$oldVal = null;
		if (array_key_exists($key,$this->_array)) $oldVal = $this->_array[$key];
		$this->_array[$key] = $value;
		return $oldVal;
	}
	
	public function get($key,$defaultValue=null) {
		if (array_key_exists($key,$this->_array)) return $this->_array[$key];
		else return $defaultValue;
	}
}