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

$modelName	= "page";
$tableName	= "pages";
$tableTitle	= "Статичные страницы";
$keyField	= "id";
$visField	= "visible";
$visControl	= true;

$fields = array(
	"id"			=> array("show"=>true,"title"=>"ИД"),
	"alias"			=> array("show"=>true,"title"=>"Алиас"),
	"title"			=> array("show"=>true,"title"=>"Заголовок"),
	"html"			=> array("show"=>false,"title"=>"Контент"),
);

$actions = array(
	"add"			=> array("title"=>"Добавить","link"=>"administrator.php?mod=static&act=modify")
);

?>