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
		$model = $this->getModel("catprm");
		if ($id != 0) {
			$model->getElement($id);
		}
		$view->assign("id",$id);
		$view->assign("cat_id",$model->cat_id);
		$view->assign("name",$model->name);
		
		return true;
	}

}

?>