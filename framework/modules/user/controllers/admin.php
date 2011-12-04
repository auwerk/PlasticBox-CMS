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
		$model = $this->getModel("user");
		if ($id != 0) {
			$model->getElement($id);
		}
		$view->assign("id",$id);
		$view->assign("name",$model->name);
		$view->assign("email",$model->email);
		$view->assign("is_admin",$model->is_admin);
		
		return true;
	}
	
	public function save() {
		$id			= Request::get("id",0);
		$name		= Request::get("name","");
		$email		= Request::get("email","");
		$p1			= Request::get("password1","");
		$p2			= Request::get("password2","");
		$is_admin_r	= Request::get("is_admin","");
		
		if (strlen($name) < 3) {
			die("Имя пользователя должно быть не менее 3 символов");
		}
		
		if ($p1 != $p2) {
			die("Введенные пароли не совпадают");
		}
		
		if (strlen($p1) < 5 && $id == 0) {
			die("Минимальная длина пароля 5 символов");
		}
		
		if ($is_admin_r == "") $is_admin = 0;
		else $is_admin = 1;
		
		$model = $this->getModel("user");
		$model->saveUser($id,$name,$email,$p1,$is_admin);
		
		$this->setRedirect("/administrator.php?mod=user");
	}

}

?>