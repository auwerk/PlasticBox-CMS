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

$modelName			= "good";
$tableName			= "goods_full";
$targetTableName	= "goods";
$tableTitle			= "Товары";
$keyField			= "id";
$visField			= "visible";
$visControl			= true;

$fields = array(
	"id"				=> array("show"=>true,"title"=>"ИД"),
	"cat_id"			=> array("show"=>true,"title"=>"ИД категории"),
	"good_name"			=> array("show"=>true,"title"=>"Наименование"),
	"description"		=> array("show"=>false,"title"=>"Описание"),
	"add_description"	=> array("show"=>false,"title"=>"Доп. описание"),
	"price1"			=> array("show"=>true,"title"=>"Цена1","readonly"=>true),
	"price2"			=> array("show"=>true,"title"=>"Цена2","readonly"=>true),
	"price3"			=> array("show"=>true,"title"=>"Цена3","readonly"=>true),
	"price4"			=> array("show"=>true,"title"=>"Цена4","readonly"=>true),
	"price5"			=> array("show"=>true,"title"=>"Цена5","readonly"=>true),
	"name"				=> array("show"=>false,"title"=>"Имя категории","readonly"=>true)
);

$actions = array(
	"add"			=> array("title"=>"Добавить","link"=>"administrator.php?mod=good&act=modify")
);

?>