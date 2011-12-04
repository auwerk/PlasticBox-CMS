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

class clientController extends Controller {
	
	public function __construct($module) {
		parent::__construct($module);
		$this->_defaultView = "page";
	}
	
	public function showPage($view) {
		$view->setLayout("default");
		$id = Request::get("id",1);
		$model = $this->getModel("page");
		$model->getElement($id);
		$view->assign("title",$model->title);
		$view->assign("html",$model->html);
	}
}

?>