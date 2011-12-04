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

final class Metadata {

	public $tableTitle		= "";
	public $tableName		= "";
	public $targetTableName	= "";
	public $keyField		= "";
	public $visField		= "";
	public $fields			= array();
	public $actions			= array();
	public $enums			= array();
	public $db_enums		= array();

	public $visControl	= false;

	public function __construct($moduleName,$metaName="meta") {
		$metaPath = PATH_MODULES.DS.$moduleName.DS.$metaName.".php";
		if (!file_exists($metaPath)) Util::fatalError("Unable to load metadata: ".$metaPath);

		include_once $metaPath;

		if (isset($modelName)) $this->modelName = $modelName;
		if (isset($tableName)) $this->tableName = $tableName;
		if (isset($tableTitle)) $this->tableTitle = $tableTitle; else $this->tableTitle = $this->tableName;
		if (isset($targetTableName)) $this->targetTableName = $targetTableName; else $this->targetTableName = $this->tableName;
		if (isset($keyField)) $this->keyField = $keyField;
		if (isset($visField)) $this->visField = $visField;
		if (isset($visControl)) $this->visControl = $visControl;
		if (isset($fields) && is_array($fields)) $this->fields = $fields;
		if (isset($actions) && is_array($actions)) $this->actions = $actions;
		if (isset($enums) && is_array($enums)) $this->enums = $enums;
		if (isset($db_enums) && is_array($db_enums)) $this->db_enums = $db_enums;

		Debugger::getInstance()->log("Metadata loaded for &quot;$moduleName&quot; module. table = $tableName, model = $modelName");
	}

	public function getFieldType($fieldName) {
		$fieldType = "string";
		if (array_key_exists($fieldName,$this->fields)) {
			$field = $this->fields[$fieldName];
			if (array_key_exists("type",$field)) $fieldType = $field["type"];
		}
		return $fieldType;
	}
}

?>