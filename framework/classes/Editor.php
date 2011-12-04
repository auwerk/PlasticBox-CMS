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

// Path to CKEditor location and URL
define('PATH_CKEDITOR',PATH_THIRD_PARTY.DS."ckeditor");
define('URL_CKEDTOR',"/third_party/ckeditor/");

// Require CKEditor
require_once PATH_CKEDITOR.DS."ckeditor.php";

class Editor {
	public static function create() {
		$editor = new CKEditor();
		$editor->basePath = URL_CKEDTOR;
		return $editor;
	}
	
	public static function place($id,$text="") {
		$editor = self::create();
		$editor->editor($id,$text);
		return $editor;
	}
} 

?>