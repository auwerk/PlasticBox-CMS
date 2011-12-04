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
		$model = $this->getModel("good");
		if ($id != 0) {
			$model->getElement($id);
			$params = $model->getParameterList();
			$view->assign("params",$params);
			$images = $model->getImages();
			$view->assign("images",$images);
		}
		$view->assign("id",$id);
		$view->assign("cat_id",$model->cat_id);
		$view->assign("good_name",$model->good_name);
		$view->assign("description",$model->description);
		$view->assign("add_description",$model->add_description);

		$view->assign("price1",$model->price1);
		$view->assign("price2",$model->price2);
		$view->assign("price3",$model->price3);
		$view->assign("price4",$model->price4);
		$view->assign("price5",$model->price5);

		return true;
	}

	public function save() {
		if (Request::get("id",0) == 0) $upd_prices = false;
		else $upd_prices = true;
		
		parent::save(); // Normal save
		
		//-- Images! --
		$uploadPath = "images".DS."goods";
		$uploadTypes = array("image/jpeg","image/png");
		$uploader = new Uploader($uploadPath,$uploadTypes);
		// Thumbnails
		$images = $uploader->upload("images",false);
		$thumbsPath = Util::getSiteUploadPath("images".DS."goods".DS."thumbs");
		foreach ($images as $img) {
			$dstPath = $thumbsPath.DS.$img->name;
			Debugger::getInstance()->log($dstPath);
			Image::generateThumb($img->path,$dstPath);
		}
		// Save to DB
		$model = $this->getModel("good");
		$model->saveImages($images);
		
		//-- Prices! --
		$prices = array();
		for ($p = 1; $p <= 5; $p++) {
			$prices[$p] = Request::get("price".$p,0);
		}
		$model->savePrices($prices,$upd_prices);
	}

	public function deleteImage() {
		$imgId = Request::get("imgid",0);
		if ($imgId != 0) {
			$model = $this->getModel("good");
			$model->deleteImage($imgId);
		}
	}
}