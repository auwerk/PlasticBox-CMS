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

$modelName	= "user";
$tableName	= "users";
$tableTitle	= "Пользователи";
$keyField	= "id";
$visControl	= false;

$fields = array(
	"id"			=> array("show"=>true,"title"=>"ИД","type"=>"number","readonly"=>1),
	"name"			=> array("show"=>true,"title"=>"Имя"),
	"passhash"		=> array("show"=>false,"title"=>"Хеш пароля"),
	"email"			=> array("show"=>true,"title"=>"e-mail"),
	"is_admin"		=> array("show"=>true,"title"=>"Администратор","type"=>"bool"),
);

$actions = array(
	"add"			=> array("title"=>"Добавить","link"=>"administrator.php?mod=user&act=modify")
);

?>