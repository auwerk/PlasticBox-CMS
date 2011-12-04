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

$modelName	= "settings";
$tableName	= "settings";
$tableTitle	= "Настройки системы";
$keyField	= "id";
$visControl	= false;

$fields = array(
	"id"			=> array("show"=>false,"title"=>"ИД"),
	"key"			=> array("show"=>true,"title"=>"Ключ"),
	"type"			=> array("show"=>true,"title"=>"Тип"),
	"vc_value"		=> array("show"=>true,"title"=>"Значение (строка)"),
	"int_value"		=> array("show"=>true,"title"=>"Значение (число)"),
	"text_value"	=> array("show"=>true,"title"=>"Значение (текст)")
);

$enums = array(
	"type"			=> array(1=>"Строка",2=>"Число",3=>"Текст")
);

$actions = array(
	"add"			=> array("title"=>"Добавить","link"=>"administrator.php?mod=settings&act=modify")
);

?>