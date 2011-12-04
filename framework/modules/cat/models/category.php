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

class categoryModel extends Model {

	public $id 			= 0;
	public $name 		= "";
	public $description = "";
	public $page_id		= 0;
	public $visible 	= 0;

	public function __construct() {
		parent::__construct("categories");
		$this->_visField = "visible";
	}

	public function getGoods($withImages=false) {
		$query = "SELECT * FROM `goods` WHERE `cat_id`=".intval($this->id);
		$this->_db->setQuery($query);
		$goods = $this->_db->loadObjectList();
		if ($withImages && count($goods) > 0) {
			$ids = "";
			foreach ($goods as $good) {
				if ($ids != "") $ids .= ",".$good->id;
				else $ids .= $good->id;
			}
			$query = "SELECT DISTINCT `good_id`,`filename` FROM `goods_img` WHERE `good_id` IN ($ids)";
			$this->_db->setQuery($query);
			$imgs = $this->_db->loadObjectList("good_id");
			foreach ($goods as $good) {
				$good->thumbPath = Util::getSiteUploadPathWeb("images/goods/thumbs")."/".$imgs[$good->id]->filename;
			}
		}
		return $goods;
	}
}

?>