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

final class Debugger {
	
	private static $_instance = null;
	public static function getInstance() {
		if (!self::$_instance) self::$_instance = new self();
		return self::$_instance;
	}
	
	private $_sqlQueries	= array();
	private $_log			= array();
	
	public function log($message) {
		$this->_log []= $message;
	}
	
	public function sql($query) {
		$this->_sqlQueries []= $query;
	}
	
	public function dump() {
		echo "<hr /><b>SQL:</b><br />";
		foreach ($this->_sqlQueries as $query) {
			echo $query."<br />";
		}
		echo "<br /><b>Log:</b><br />";
		foreach ($this->_log as $msg) {
			echo $msg."<br />";
		}
		echo "<hr />";
	}
	
}

?>