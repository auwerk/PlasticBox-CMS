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

final class Renderer {
	private static $_instance = null;
	public static function getInstance() {
		if (!self::$_instance) self::$_instance = new self();
		return self::$_instance;
	}

	private $_layout		= "";
	private $_stylesheets	= array();
	private $_jscripts		= array();

	private function __construct() {
		$this->_layout = Configuration_CMS::$_defaultLayout;
		$this->assign("title",Configuration_CMS::$_siteTitle);
	}

	// -------------- Renderable interface implementation ----------------
	public function setLayout($layout) {
		$this->_layout = $layout;
	}

	public function assign($name,$value="") {
		$this->$name = $value;
	}

	public function render() {
		if (defined("_ADMIN_MODE")) {
			$layoutPath = PATH_FRAMEWORK.DS."template".DS.$this->_layout.".php";
		}
		else {
			$siteDirectory = Registry::getInstance()->get("siteDirectory",PATH_SITES);
			$layoutPath = $siteDirectory.DS."template".DS.$this->_layout.".php";
		}

		if (!file_exists($layoutPath)) Util::fatalError("Layout not found: $layoutPath");
		$this->renderModule();
		include_once $layoutPath;
	}
	// --------------------------------------------------------------------

	protected function renderModule() {
		ob_start();
		Module::getInstance()->execute();
		$moduleHtml = ob_get_contents();
		ob_end_clean();
		$this->assign("moduleHTML",$moduleHtml);
	}

	protected function renderHead($title="") {
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html;charset=UTF-8\" />\n";
		echo "\t\t<meta name=\"generator\" content=\"".Version::getGenerator()."\" />\n";
		if ($title == "") {
			$titleTail = ""; if (defined("_ADMIN_MODE")) $titleTail = " - \"Админка\"";
			$title = Configuration_CMS::$_siteTitle.$titleTail;
		}
		echo "\t\t<title>$title</title>\n";
		foreach ($this->_stylesheets as $stylesheet) {
			echo "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"$stylesheet\" />\n";
		}
		echo "\t\t<script type=\"text/javascript\" src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js\"></script>\n";
		foreach ($this->_jscripts as $jscript) {
			echo "\t\t<script type=\"text/javascript\" src=\"$jscript\"></script>\n";
		}
	}

	public function addStylesheet($href,$framework=false) {
		if ($framework) {
			$href = "/framework/css/".$href;
		}
		else {
			$href = "/sites/".Configuration_CMS::$_siteName."/css/".$href;
		}
		$this->_stylesheets []= $href;
	}
	
	public function addJScript($href,$framework=false) {
		if ($framework) {
			$href = "/framework/js/".$href;
		}
		else {
			$href = "/sites/".Configuration_CMS::$_siteName."/js/".$href;
		}
		$this->_jscripts []= $href;
	}

}

?>