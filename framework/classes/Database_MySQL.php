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

final class Database_MySQL {

	private $_dbHost		= "";
	private $_dbName		= "";
	private $_dbUser		= "";
	private $_dbPassword	= "";
	private $_dbPrefix		= "";

	private $_connection	= false;
	private $_query			= "";
	private $_cursor		= 0;

	public function __construct() {
		$this->_dbHost = Configuration_CMS::$_dbHost;
		$this->_dbName = Configuration_CMS::$_dbName;
		$this->_dbUser = Configuration_CMS::$_dbUser;
		$this->_dbPassword = Configuration_CMS::$_dbPassword;

		$this->connect();
	}

	public function __destruct() {
		if (is_resource($this->_connection)) {
			@mysql_close($this->_connection);
		}
	}

	private function connect() {
		if (!function_exists("mysql_connect")) {
			Util::fatalError("No MySQL support on server");
		}

		// Connect
		if (!$this->_connection = @mysql_connect($this->_dbHost,$this->_dbUser,$this->_dbPassword)) {
			Util::fatalError("Failed to connect to MySQL database: ".mysql_error());
		}

		// Select DB
		if (!@mysql_select_db($this->_dbName,$this->_connection)) {
			Util::fatalError("Failed to select MySQL database: ".mysql_error());
		}
		
		@mysql_query("SET NAMES utf8");
		Debugger::getInstance()->log("Connected to database");
	}

	public function query($query="") {
		if (!is_resource($this->_connection)) {
			return false;
		}

		if ($query == "") $query = $this->_query;
		Debugger::getInstance()->sql($query);

		$this->_cursor = @mysql_query($query,$this->_connection);
		if (!$this->_cursor) {
			Util::fatalError("MySQL query failed: ".mysql_error()."<br />".$query);
			return false;
		}
		else return $this->_cursor;
	}

	public function loadResult() {
		if (!($cur = $this->query())) {
			return null;
		}
		$ret = null;
		if ($row = mysql_fetch_row($cur)) {
			$ret = $row[0];
		}
		mysql_free_result($cur);
		return $ret;
	}

	public function loadResultArray($numinarray = 0) {
		if (!($cur = $this->query())) {
			return null;
		}
		$array = array();
		while ($row = mysql_fetch_row($cur)) {
			$array[] = $row[$numinarray];
		}
		mysql_free_result($cur);
		return $array;
	}

	public function loadObject($className = 'stdClass') {
		if (!($cur = $this->query())) {
			return null;
		}
		$ret = null;
		if ($object = mysql_fetch_object($cur, $className)) {
			$ret = $object;
		}
		mysql_free_result($cur);
		return $ret;
	}

	public function loadObjectList($key='', $className = 'stdClass') {
		if (!($cur = $this->query())) {
			return null;
		}
		$array = array();
		while ($row = mysql_fetch_object($cur, $className)) {
			if ($key) {
				$array[$row->$key] = $row;
			} else {
				$array[] = $row;
			}
		}
		mysql_free_result($cur);
		return $array;
	}
	
	public function insertId() {
		return mysql_insert_id($this->_connection);
	}


	public function setQuery($query) {
		$this->_query = $query;
	}
}

?>