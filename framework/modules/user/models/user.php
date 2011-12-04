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

class userModel extends Model {

	public $id 			= 0;
	public $name		= "";
	public $passhash	= "";
	public $email		= "";
	public $is_admin	= 0;

	public function __construct() {
		parent::__construct("users");
	}

	public function saveUser($id,$name,$email,$password,$is_admin) {
		if ($id == 0) {
			$passhash = md5($password);
			$query = "INSERT INTO `users`(`id`,`name`,`passhash`,`email`,`is_admin`) VALUES($id,'$name','$passhash','$email',$is_admin)";
		}
		else {
			$query = "UPDATE `users` SET `name`='$name', `email`='$email', `is_admin`=$is_admin";
			if ($password != "") {
				$passhash = md5($password);
				$query .= ", `passhash`='$passhash'";
			}
			$query .= " WHERE `id`=$id";
		}

		$this->_db->setQuery($query);
		$this->_db->query();
	}
}

?>