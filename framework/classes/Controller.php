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

class Controller {

	private $_loadedViews = array();
	protected $_metadata = null;
	protected $_defaultAct = "show";
	protected $_defaultView = "list";
	private $_redirectUrl = "";
	private $_module = null;

	public function __construct($module) {
		$this->_module = $module;
		$this->_metadata = Registry::getInstance()->get("metadata",null);
		if (defined("_ADMIN_MODE")) $this->_defaultAct = "listShow";
	}

	protected function getView($viewName) {
		$viewName = strtolower($viewName);
		if (!array_key_exists($viewName,$this->_loadedViews)) {
			$modulePath = Registry::getInstance()->get("modulePath",PATH_ROOT);
			$scriptPath = $modulePath.DS."views".DS.$viewName.".php";
			if (file_exists($scriptPath)) {
				require_once $scriptPath;
				$viewClass = $viewName."View";
				if (!class_exists($viewClass)) Util::fatalError("Unable to load view class for: ".$viewName);
				$this->_loadedViews[$viewName] = new $viewClass($viewName);
			}
			else $this->_loadedViews[$viewName] = new View($viewName);
		}
		return $this->_loadedViews[$viewName];
	}

	protected function getModel($modelName) {
		return $this->_module->getModel($modelName);
	}

	protected function setRedirect($url) {
		$this->_redirectUrl = $url;
	}

	public function execute() {
		$act = Request::get("act",$this->_defaultAct);
		if (method_exists($this,$act)) $this->$act();
		if ($this->_redirectUrl) Util::redirect($this->_redirectUrl);
	}

	public function show() {
		$viewName = Request::get("view",$this->_defaultView);
		$showMethod = "show".ucfirst($viewName);
		$view = $this->getView($viewName);
		if (method_exists($this,$showMethod)) $this->$showMethod($view);
		$view->render();
	}

	public function save() {
		if (!is_object($this->_metadata)) return false;
		$meta = $this->_metadata;

		$model = $this->getModel($meta->modelName);
		$model->bindData($_REQUEST);
		$model->saveElement();

		$this->setRedirect("/administrator.php?mod=".Registry::getInstance()->get("moduleName"));
	}

	public function delete() {
		if (!is_object($this->_metadata)) return false;
		$meta = $this->_metadata;

		$keys = Request::get("checks",array());
		$model = $this->getModel($meta->modelName);
		if (count($keys) > 1) $model->deleteElements($keys);
		else if (count($keys) == 1) {
			foreach ($keys as $key=>$val) {
				$model->deleteElement($key);
			}
		}
		$this->setRedirect("/administrator.php?mod=".Registry::getInstance()->get("moduleName"));
	}

	public function listShow() {
		if (!is_object($this->_metadata)) return false;
		$meta = $this->_metadata;

		$model = $this->getModel($meta->modelName);
		$rows = $model->getList();
		$view = new View("");
		$view->displayList($rows);
	}

	public function setvis() {
		if (!is_object($this->_metadata)) return false;
		$meta = $this->_metadata;

		$vf = intval(Request::get("vis",0));
		$vk = Request::get($meta->keyField,0);
		$model = $this->getModel($meta->modelName);
		$model->setVisibility($vk,$vf);
		$this->setRedirect("/administrator.php?mod=".Registry::getInstance()->get("moduleName"));
	}

	public function modify() {
		$view = $this->getView("modify");
		$view->setLayout("default");
		if ($this->prepareModify($view)) $view->render();
	}

	public function prepareModify($view) {
		// Returns true if View::render() is needed
		if ($view->getName() == "modify") {
			$view->displayModify($this);
			return false;
		}
		else return true;
	}

}

?>