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

final class User {
	private static $_instance = null;
	public static function getInstance() {
		if (!self::$_instance) self::$_instance = new self();
		return self::$_instance;
	}

	private $id			= 0;
	private $name 		= "";
	private $email 		= "";
	private $is_admin 	= 0;

	private function __construct() {
		$this->id = 0;
		$this->auth();
	}

	private function loadById($uid) {
		$query = "SELECT * FROM `users` WHERE `id`=".intval($uid);
		$db = Database::getInstance();
		$db->setQuery($query);
		$obj = $db->loadObject();
		if ($obj) {
			$this->id = $obj->id;
			$this->name = $obj->name;
			$this->email = $obj->email;
			$this->is_admin = $obj->is_admin;
			$this->passhash = $obj->passhash;
		}
		else $id = 0;
	}

	private function loadByName($name) {
		$query = "SELECT * FROM `users` WHERE `name`='$name'";
		$db = Database::getInstance();
		$db->setQuery($query);
		$obj = $db->loadObject();
		if ($obj) {
			$this->id = $obj->id;
			$this->name = $obj->name;
			$this->email = $obj->email;
			$this->is_admin = $obj->is_admin;
			$this->passhash = $obj->passhash;
		}
		else $id = 0;
	}

	private function auth() {
		$userCookie = Request::getCookie("__user");
		if ($userCookie != "") {
			$userCookie = base64_decode($userCookie);
			$userCookie = explode(":",$userCookie);
			$this->loadById($userCookie[1]);
		}
	}

	public function login() {
		$userName = Request::get("user_name","");
		$userPass = Request::get("user_password","");

		if ($userName != "" && $userPass != "") {
			$this->loadByName($userName);
			if ($this->id == 0) return false;
			if ($this->passhash != md5($userPass)) return false;
				
			//--- Set cookie ---
			$userCookie = time().":".$this->id;
			$userCookie = base64_encode($userCookie);
			setcookie("__user",$userCookie,time()+60*60*24*30,"/");
			//------------------
				
			return true;
		}
		else return false;
	}

	public function logout() {
		if (defined("_ADMIN_MODE")) $redirectUrl = "administrator.php";
		else $redirectUrl = "index.php";

		setcookie("__user");

		Util::redirect($redirectUrl);
	}

	public function loginForm() {
		$loginError = Request::getInt("loginError");

		$renderer = Renderer::getInstance();
		$renderer->setLayout("login");
		$renderer->assign("loginError",$loginError);
	}

	public function maintenanceMessage() {
		$renderer = Renderer::getInstance();
		$renderer->setLayout("maintenance");
	}

	public function isAdmin() {
		return ($this->is_admin == 1);
	}
}

?>