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

$modelName	= "category";
$tableName	= "categories";
$tableTitle	= "Категории товаров";
$keyField	= "id";
$visField	= "visible";
$visControl	= true;

$fields = array(
	"id"			=> array("show"=>true,"title"=>"ИД"),
	"name"			=> array("show"=>true,"title"=>"Наименование"),
	"description"	=> array("show"=>true,"title"=>"Описание"),
	"page_id"		=> array("show"=>true,"title"=>"Страница")
);

$db_enums = array(
	"page_id"		=> array("table"=>"pages","key"=>"id","value"=>"title")
);

$actions = array(
	"add"			=> array("title"=>"Добавить","link"=>"administrator.php?mod=cat&act=modify")
);

?>