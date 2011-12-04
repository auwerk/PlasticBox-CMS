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

class pageModel extends Model {

	public $id 			= 0;
	public $html		= "";
	public $alias		= "";
	public $title		= "";
	
	public function __construct() {
		parent::__construct("pages");
	}
}

?>