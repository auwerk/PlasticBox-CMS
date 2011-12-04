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

class Widget {

	private static $_loadedWidgets = array();
	public static function getInstance($widgetName) {
		$widgetName = strtolower($widgetName);
		if (!array_key_exists($widgetName,self::$_loadedWidgets)) {
			// Load widget code
			$scriptPath = Path::getSite("widgets".DS.$widgetName.".php");
			if (!file_exists($scriptPath)) {
				$scriptPath = Path::getFramework("widgets".DS.$widgetName.".php");
			}
			if (!file_exists($scriptPath)) Util::fatalError("Unable to load widget script: $widgetName");
			require_once $scriptPath;
			$widgetClass = $widgetName."Widget";
			if (!class_exists($widgetClass)) Util::fatalError("Unable to load widget class: $widgetName");
			self::$_loadedWidgets[$widgetName] = new $widgetClass();
		}
		return self::$_loadedWidgets[$widgetName];
	}

	private function __construct() {
		//
	}

	public function bindData($data=array()) {
		foreach ($data as $key=>$value) {
			$this->$key = $value;
		}
	}

	public static function place($widgetName,$data=array()) {
		$widget = Widget::getInstance($widgetName);
		if ($widget) {
			$widget->bindData($data);
			$widget->render();
		}
	}

	protected function getModel($modelName,$moduleName="") {
		return Module::getInstance($moduleName)->getModel($modelName);
	}

	public function render() {
		// Override it
	}

}

?>