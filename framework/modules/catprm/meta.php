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

$modelName	= "catprm";
$tableName	= "cat_params";
$tableTitle	= "Параметры категорий";
$keyField	= "id";
$visControl	= false;

$fields = array(
	"id"			=> array("show"=>false,"title"=>"ИД"),
	"cat_id"		=> array("show"=>true,"title"=>"ИД категории"),
	"name"			=> array("show"=>true,"title"=>"Наименование"),
);

$actions = array(
	"add"			=> array("title"=>"Добавить","link"=>"administrator.php?mod=catprm&act=modify")
);

?>