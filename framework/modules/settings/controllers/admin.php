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
		$model = $this->getModel("settings");
		if ($id != 0) {
			$model->getElement($id);
		}
		$view->assign("id",$id);
		$view->assign("key",$model->key);
		$view->assign("vc_value",$model->vc_value);
		$view->assign("int_value",intval($model->int_value));
		$view->assign("text_value",$model->text_value);
		
		$vc_sel = ""; $int_sel = ""; $text_sel = "";
		if ($model->type == 1) $vc_sel = " selected=\"selected\"";
		if ($model->type == 2) $int_sel = " selected=\"selected\"";
		if ($model->type == 3) $text_sel = " selected=\"selected\"";
		$view->assign("vc_sel",$vc_sel);
		$view->assign("int_sel",$int_sel);
		$view->assign("text_sel",$text_sel);
		
		return true;
	}

}

?>