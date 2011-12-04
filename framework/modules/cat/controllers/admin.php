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

class adminController extends Controller {
	
	public function prepareModify($view) {
		$id = Request::get("id",0);
		$model = $this->getModel("category");
		if ($id != 0) {
			$model->getElement($id);
		}
		$view->assign("id",$id);
		$view->assign("name",$model->name);
		$view->assign("description",$model->description);
		$view->assign("page_id",$model->page_id);
		
		return true;
	}

}

?>