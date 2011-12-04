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

	public function showFlypage($view) {
		$view->setLayout("default");

		$id = Request::getInt("id");
		$model = $this->getModel("good");
		if ($model->getElement($id)) {
			$images = $model->getImages();
			$view->assign("images",$images);
			$view->assign("good_name",$model->good_name);
			$view->assign("description",$model->description);
			$view->assign("add_description",$model->add_description);
			$view->assign("cat_name",$model->name);
			$view->assign("cat_id",$model->cat_id);
		}
		$view->assign("id",$model->id);
	}

}

?>