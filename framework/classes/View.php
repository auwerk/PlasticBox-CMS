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

class View {

	protected $_metadata	= null;
	private $_layout		= "";
	private $_name			= "";
	private $_moduleName	= "";

	public function __construct($name) {
		$this->_name		= $name;
		$this->_metadata	= Registry::getInstance()->get("metadata",null);
		$this->_moduleName = Registry::getInstance()->get("moduleName");
	}
	
	public function getName() {
		return $this->_name;
	}

	// -------------- Renderable interface implementation ----------------
	public function setLayout($layout) {
		$this->_layout = $layout;
	}

	public function assign($key,$value) {
		$this->$key = $value;
	}

	public function render() {
		if ($this->_layout == "") return false;
		$layoutPath = Registry::getInstance()->get("modulePathClient").DS."views".DS.$this->_name.DS.$this->_layout.".php";
		if (!file_exists($layoutPath)) {
			$layoutPath = Registry::getInstance()->get("modulePath").DS."views".DS.$this->_name.DS.$this->_layout.".php";
		}
		if (!file_exists($layoutPath)) echo "Layout not found: $layoutPath";
		else include_once $layoutPath;
	}
	//--------------------------------------------------------------------
	
	private function displayFieldEditor($fieldName,$fieldType,$defaultValue) {
		$html = "";
		if ($fieldType == "text") {
			// Editor
		}
		else if ($fieldType == "bool") {
			if ($defaultValue == 1) $checked = "checked=\"checked\"";
			else $checked = "";
			$html = "<input name=\"$fieldName\" type=\"checkbox\" $checked />";
		}
		else {
			switch ($fieldType) {
				case "string": $inputType = "text"; break;
				case "number": $inputType = "text"; break;
				case "password": $inputType = "password"; break;
				default: $inputType = "text"; break;
			}
			$html = "<input name=\"$fieldName\" type=\"$inputType\" value=\"$defaultValue\" />";
		}
		return $html;
	}

	public function displayModify($row=null) {
		if (!is_object($row)) $row = $this;
		if (!is_object($this->_metadata)) return false;
		$meta = $this->_metadata;
		
		echo "<table>";
		foreach ($meta->fields as $fieldName=>$field) {
			echo "<tr><td>".$field["title"]."</td>";
			$defaultValue = Util::getProperty($row,$fieldName,"");			
			if (Util::getProperty($field,"readonly",0) != 0) echo "<td>$defaultValue</td>";
			else echo "<td>".$this->displayFieldEditor($fieldName,$meta->getFieldType($fieldName),$defaultValue)."</td></tr>";
		}
		echo "</table>";
	}

	public function displayList($rows,$cssClass="admin-table") {
		if (!is_object($this->_metadata)) return false;
		$meta = $this->_metadata;

		echo "<center><h1>".$meta->tableTitle."</h1></center>";

		echo "<table><tr>";
		foreach ($meta->actions as $action) {
			echo "<td><a class=\"static-link\" href=\"".$action["link"]."\">".$action["title"]."</a></td>";
		}
		echo "</tr></table>";

		$moduleName = $this->_moduleName;
		echo "<form action=\"administrator.php\" method=\"post\">";
		echo "<input type=\"hidden\" name=\"mod\" value=\"$moduleName\" />";
		echo "<input type=\"hidden\" name=\"act\" value=\"delete\" />";
		echo "<table class=\"$cssClass\">";
		echo "<tr>";
		echo "<th>&nbsp;</th>";
		$fieldsOut = 0;
		foreach ($meta->fields as $fieldName=>$fieldDesc) {
			if ($fieldDesc["show"]) {
				echo "<th>".$fieldDesc["title"]."</th>";
				$fieldsOut++;
			}
		}
		$colInc = 1;
		if ($meta->visControl) {
			$colInc++;
			echo "<th>Видимость</th>";
		}
		echo "</tr>";
		$keyField = $meta->keyField;
		$visLink = "administrator.php?mod=".$moduleName."&act=setvis";
		$modLink = "administrator.php?mod=".$moduleName."&act=modify";
		if (Util::isFilled($rows)) {
			foreach ($rows as $row) {
				$ml = $modLink."&".$keyField."=".$row->$keyField;
				echo "<tr ondblclick=\"document.location.href='$ml';\">";
				echo "<td><input type=\"checkbox\" name=\"checks[".$row->$keyField."]\" /></td>";
				foreach ($meta->fields as $fieldName=>$fieldDesc) {
					if ($fieldDesc["show"]) {
						$fieldValue = $row->$fieldName;
						if (array_key_exists($fieldName,$meta->enums)) {
							$fieldValue = ArrayHelper::getKeyValue($fieldValue,$meta->enums[$fieldName],$fieldValue);
						}
						echo "<td>".$fieldValue."</td>";
					}
				}
				if ($meta->visControl) {
					$vf = $meta->visField;
					$vl = $visLink."&".$keyField."=".$row->$keyField;
					if ($row->$vf == 1) {
						$vl .= "&vis=0";
						echo "<td><a class=\"static-link\" href=\"$vl\">Скрыть</a></td>";
					}
					else {
						$vl .= "&vis=1";
						echo "<td><a class=\"static-link\" href=\"$vl\">Показать</a></td>";
					}
				}
				echo "</tr>";
			}
		}
		else {
			echo "<tr><td colspan=\"".($fieldsOut + $colInc)."\">Нет записей для отображения</td></tr>";
		}
		echo "</table>";
		echo "<br /><input type=\"submit\" value=\"Удалить\" />";
		echo "</form>";
	}
}

?>