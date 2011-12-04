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

class catprmModel extends Model {

	public $id 			= 0;
	public $cat_id		= 0;
	public $name 		= "";
	
	public function __construct() {
		parent::__construct("cat_params");
	}

	public function getList() {
		$query = "SELECT * FROM `cat_params`";
		$this->_db->setQuery($query);
		return $this->_db->loadObjectList();
	}
}

?>