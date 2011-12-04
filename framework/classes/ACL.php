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

final class ACLManager {
	private static $_instance = null;
	public static function getInstance() {
		if (!self::$_instance) self::$_instance = new self();
		return self::$_instance;
	}
	
	
	private $_rules = array();
	
	private function __construct() {
		$this->loadAll(0);
	}
	
	private function loadAll($roleId) {
		$db = Database::getInstance();
		$query = "SELECT * FROM `acl_rules` AS aclr LEFT JOIN `acl` AS acl ON acl.id=aclr.acl_id WHERE aclr.role_id=".intval($roleId);
		$db->setQuery($query);
		$this->_rules = $db->loadObjectList("name");
	}
}

?>