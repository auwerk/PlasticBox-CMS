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

class settingsModel extends Model {
	
	public $id = 0;
	public $key = "";
	public $type = 0;
	public $vc_value = "";
	public $int_value = 0;
	public $text_value = "";
	
	public function __construct() {
		parent::__construct("settings");
	}
}

?>