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

class Module {

	//
	// Module loader
	//
	private static $_loadedModules = array();
	public static function getInstance($moduleName="") {
		if ($moduleName == "") {
			$moduleName = Request::get("mod",Configuration_CMS::$_defaultModule);
			$mainModule = true;
		}
		else $mainModule = false;
		if (!array_key_exists($moduleName,self::$_loadedModules)) {
			// Load module
			$db = Database::getInstance();
			$db->setQuery("SELECT * FROM `modules` WHERE `name`='$moduleName'");
			$moduleRow = $db->loadObject();
			if (!$moduleRow) {
				Util::fatalError("Module is not installed: &quot;".$moduleName."&quot;");
			}
			if ($moduleRow->enabled != 1) {
				Util::fatalError("Module is disabled: &quot;".$moduleName."&quot;");
			}
			Debugger::getInstance()->log("Data loaded for &quot;$moduleName&quot; module");
			// Load module code
			$modulePath = PATH_MODULES.DS.$moduleName;
			if ($moduleRow->external == 1) {
				$siteDirectory = Registry::getInstance()->get("siteDirectory",PATH_ROOT);
				$modulePath = $siteDirectory.DS."modules".DS.$moduleName;
			}
			$scriptPath = $modulePath.DS.$moduleName.".php";
			if (!file_exists($scriptPath)) Util::fatalError("Module &quot;$moduleName&quot; is not installed properly: no main script");
			require_once $scriptPath;
			$moduleClassName = strtolower($moduleName)."Module";
			if (!class_exists($moduleClassName,false)) {
				Util::fatalError("Module &quot;$moduleName&quot; is invalid: no main class");
			}
			self::$_loadedModules[$moduleName] = new $moduleClassName($modulePath,$moduleRow,$mainModule);
			Debugger::getInstance()->log("Code loaded for &quot;$moduleName&quot; module");
		}
		return self::$_loadedModules[$moduleName];
	}

	public static function getModulesList() {
		$db = Database::getInstance();
		$query = "SELECT * FROM `modules` WHERE `enabled`=1";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	//-------------------

	private $_data			= null;
	private $_path			= "";
	protected $_metadata	= null;
	private $_loadedModels = array();

	private function __construct($modulePath,$moduleData,$isMain=false) {
		$this->_path = $modulePath;
		$this->_data = $moduleData;
		if ($isMain) {
			Registry::getInstance()->set("modulePath",$modulePath);
			$clientPath = Registry::getInstance()->get("siteDirectory").DS."modules".DS.$this->getName();
			Registry::getInstance()->set("modulePathClient",$clientPath);
		}
		$this->configure();
	}

	public function configure() {
		// Override it
	}

	private function loadController() {
		if (defined("_ADMIN_MODE")) $controllerName = "admin";
		else $controllerName = "client";
		$scriptPath = $this->_path.DS."controllers".DS.$controllerName.".php";
		if (!file_exists($scriptPath)) Util::fatalError("Unable to find script with controller: ".$controllerName." (".$this->getName().")");
		require_once $scriptPath;
		$controllerClass = $controllerName."Controller";
		if (!class_exists($controllerClass,false)) Util::fatalError("Unable to find controller class: ".$controllerName);
		$controllerClass = new $controllerClass($this);
		return $controllerClass;
	}

	protected function loadMetadata($metaName="meta") {
		$this->_metadata = new Metadata($this->getName(),$metaName);
		Registry::getInstance()->set("metadata",$this->_metadata);
	}

	public function getModel($modelName) {
		$modelName = strtolower($modelName);
		if (!array_key_exists($modelName,$this->_loadedModels)) {
			$modulePath = $this->getPath();
			$scriptPath = $modulePath.DS."models".DS.$modelName.".php";
			if (!file_exists($scriptPath)) Util::fatalError("Unable to load model script ($scriptPath) for: ".$modelName);
			require_once $scriptPath;
			$modelClass = $modelName."Model";
			if (!class_exists($modelClass)) Util::fatalError("Unable to load model class for: ".$modelName);
			$this->_loadedModels[$modelName] = new $modelClass();
		}
		return $this->_loadedModels[$modelName];
	}

	public function getPath() {
		return $this->_path;
	}
	public function getName() {
		return $this->_data->name;
	}

	public function execute() {
		Registry::getInstance()->set("h1",$this->_data->title);
		Registry::getInstance()->set("moduleName",$this->getName());
		$controller = $this->loadController();
		$controller->execute();
	}

}

?>