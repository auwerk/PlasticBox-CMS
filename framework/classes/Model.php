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

class Model {
	
	public static function getInstance($modelName,$moduleName="") {
		return Module::getInstance($moduleName)->getModel($modelName);
	}
	
	//-------------------------------------------------------------------------------------

	protected $_db			= null;
	protected $_metadata	= null;

	public function __construct($tableName,$keyField="id") {
		$this->_db			= Database::getInstance();
		$this->_metadata	= Registry::getInstance()->get("metadata",null);
	}

	public function getElement($keyValue) {
		if (!is_object($this->_metadata)) return false;
		$meta = $this->_metadata;

		$query = "SELECT ";
		$noComma = true;
		foreach ($meta->fields as $fieldName=>$fieldDesc) {
			if ($noComma) {
				$query .= "`$fieldName`";
				$noComma = false;
			}
			else $query .= ", `$fieldName`";
		}
		$query .= " FROM `".$meta->tableName."` WHERE `".$meta->keyField."`='$keyValue'";
		$this->_db->setQuery($query);
		$obj = $this->_db->loadObject();
		if ($obj) {
			$objFields = get_object_vars($obj);
			foreach ($objFields as $ofName=>$ofValue) {
				$this->$ofName = $ofValue;
			}
			return $this;
		}
		else return false;
	}

	public function bindData($data) {
		if (!is_object($this->_metadata)) return false;
		$meta = $this->_metadata;

		foreach ($meta->fields as $fieldName=>$fieldDesc) {
			if (array_key_exists($fieldName,$data)) $this->$fieldName = $data[$fieldName];
		}
	}

	public function saveElement($obj=null) {
		if (!is_object($obj)) $obj = $this;
		if (!is_object($this->_metadata)) return false;
		$meta = $this->_metadata;
		$keyField = $meta->keyField;

		$insertQ = false;
		if ($obj->$keyField != 0) {
			// Update
			$query = "UPDATE `".$meta->targetTableName."` SET ";
			$noComma = true;
			foreach ($meta->fields as $fieldName=>$fieldDesc) {
				if (Util::getProperty($fieldDesc,"readonly",false) == true) continue;
				$fieldValue = ""; if (isset($obj->$fieldName)) $fieldValue = $obj->$fieldName;
				if ($noComma) {
					$query .= "`$fieldName`='$fieldValue'";
					$noComma = false;
				}
				else $query .= ", `$fieldName`='$fieldValue'";
			}
			$query .= " WHERE `$keyField`='".$obj->$keyField."'";
		}
		else {
			// Insert
			$insFields = "`$keyField`";
			$insVals = "'0'";
			foreach ($meta->fields as $fieldName=>$fieldDesc) {
				if (Util::getProperty($fieldDesc,"readonly",false) == true) continue;
				$fieldValue = ""; if (isset($obj->$fieldName)) $fieldValue = $obj->$fieldName;
				if ($fieldName != $keyField) {
					$insFields .= ",`$fieldName`";
					$insVals .= ",'$fieldValue'";
				}
			}
			$query = "INSERT INTO `".$meta->targetTableName."`($insFields) VALUES($insVals)";
			$insertQ = true;
		}

		$this->_db->setQuery($query);
		$this->_db->query();
		
		if ($insertQ) {
			$this->$keyField = $this->_db->insertId();
		}
	}

	public function getList($visibleOnly=false) {
		if (!is_object($this->_metadata)) return false;
		$meta = $this->_metadata;

		$query = "SELECT ";
		$noComma = true;
		foreach ($meta->fields as $fieldName=>$fieldDesc) {
			if ($noComma) {
				$query .= "`$fieldName`";
				$noComma = false;
			}
			else $query .= ", `$fieldName`";
		}
		if ($meta->visControl) $query .= ", `".$meta->visField."`";
		$query .= " FROM `".$meta->tableName."`";
		if ($visibleOnly) $query .= " WHERE `".$meta->visField."`=1";
		$this->_db->setQuery($query);
		return $this->_db->loadObjectList();
	}

	public function deleteElement($keyValue) {
		if (!is_object($this->_metadata)) return false;
		$meta = $this->_metadata;
		
		$query = "DELETE FROM `".$meta->targetTableName."` WHERE `".$meta->keyField."`='$keyValue'";
		$this->_db->setQuery($query);
		$this->_db->query();
	}

	public function deleteElements($keys) {
		if (!is_object($this->_metadata)) return false;
		$meta = $this->_metadata;
		
		$keysIn = ""; $noComma = true;
		foreach ($keys as $key=>$value) {
			if ($noComma) {
				$keysIn .= "'$key'";
				$noComma = false;
			}
			else $keysIn .= ",'$key'";
		}
		$query = "DELETE FROM `".$meta->targetTableName."` WHERE `".$meta->keyField."` IN ($keysIn)";
		$this->_db->setQuery($query);
		$this->_db->query();
	}

	public function setVisibility($keyValue,$flag) {
		if (!is_object($this->_metadata)) return false;
		$meta = $this->_metadata;

		if ($meta->visField) {
			$query = "UPDATE `".$meta->targetTableName."` SET `".$meta->visField."`=".intval($flag)." WHERE `".$meta->keyField."`='$keyValue'";
			$this->_db->setQuery($query);
			$this->_db->query();
		}
	}

}

?>