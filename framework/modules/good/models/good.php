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

class goodModel extends Model {

	public $id 				= 0;
	public $cat_id			= 0;
	public $good_name		= "";
	public $description		= "";
	public $add_description	= "";
	public $name			= "";
	
	public function __construct() {
		parent::__construct("goods");
	}
	
	public function getParameterList() {
		$query = "SELECT cp.*, cpv.value FROM cat_params AS cp LEFT JOIN cat_param_vals AS cpv ON (cpv.param_id=cp.id AND cpv.good_id=".intval($this->id).") WHERE cp.cat_id=".intval($this->cat_id);
		$this->_db->setQuery($query);
		return $this->_db->loadObjectList();
	}
	
	public function saveImages($images) {
		$goodId = $this->id;
		foreach ($images as $img) {
			$query = "INSERT INTO `goods_img`(`id`,`good_id`,`filename`) VALUES(0,".$goodId.",'".$img->name."')";
			$this->_db->setQuery($query);
			$this->_db->query();
		}
	}
	
	public function getImages() {
		$query = "SELECT * FROM `goods_img` WHERE `good_id`=".$this->id;
		$this->_db->setQuery($query);
		$images = $this->_db->loadObjectList();
		foreach ($images as $img) {
			$img->bigPath = Util::getSiteUploadPathWeb("images/goods")."/".$img->filename;
			$img->thumbPath = Util::getSiteUploadPathWeb("images/goods/thumbs")."/".$img->filename;
		}
		return $images;
	}
	
	public function deleteImage($imgId) {
		$query = "SELECT * FROM `goods_img` WHERE `id`=".intval($imgId);
		$this->_db->setQuery($query);
		$img = $this->_db->loadObject();
		if ($img) {
			$path = Util::getSiteUploadPath("images".DS."goods").DS.$img->filename;
			$thumbPath = Util::getSiteUploadPath("images".DS."goods".DS."thumbs").DS.$img->filename;
			unlink($path);
			unlink($thumbPath);
			$query = "DELETE FROM `goods_img` WHERE `id`=".intval($imgId);
			$this->_db->setQuery($query);
			$this->_db->query();
		}
	}
	
	/* Prices */
	
	public function savePrices($prices,$upd=false) {
		$p1 = intval($prices[1]);
		$p2 = intval($prices[2]);
		$p3 = intval($prices[3]);
		$p4 = intval($prices[4]);
		$p5 = intval($prices[5]);
		if ($upd) {
			$query = "UPDATE `prices` SET `price1`=$p1, `price2`=$p2, `price3`=$p3, `price4`=$p4, `price5`=$p5 WHERE `good_id`=".$this->id;
		}
		else {
			$query = "INSERT INTO `prices`(`good_id`,`price1`,`price2`,`price3`,`price4`,`price5`) VALUES(".$this->id.",$p1,$p2,$p3,$p4,$p5)";
		}
		$this->_db->setQuery($query);
		$this->_db->query();
	}
}

?>