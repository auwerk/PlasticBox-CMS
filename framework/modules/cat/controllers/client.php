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
	
	public function showList($view) {
		$model = $this->getModel("category");
		$cats = $model->getList(true);
		$view->setLayout("default");
		$view->assign("cats",$cats);
	}
	
	public function showGoods($view) {
		$id = Request::getInt("id");
		
		$view->setLayout("default");
		$model = $this->getModel("category");
		if ($model->getElement($id)) {
			$goods = $model->getGoods(true);
			$view->assign("goods",$goods);
		}
		$view->assign("id",$model->id);
		$view->assign("name",$model->name);
		$view->assign("description",$model->description);
		$view->assign("page_id",$model->page_id);
	}

}

?>