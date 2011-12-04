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

// Guard
define('_PB_VALID',1);

// Paths
define("PATH_SITES"			,	PATH_ROOT.DS."sites");
define("PATH_THIRD_PARTY"	,	PATH_ROOT.DS."third_party");
define("PATH_CLASSES"		,	PATH_FRAMEWORK.DS."classes");
define("PATH_MODULES"		,	PATH_FRAMEWORK.DS."modules");
define("PATH_WIDGETS"		,	PATH_FRAMEWORK.DS."widgets");

// Load global CMS configuration
$generalCfgPath = PATH_ROOT.DS."configuration.php";
if (file_exists($generalCfgPath)) {
	require_once $generalCfgPath;
}
else die("General configuration file is missing");

// Load the loader :)
require_once PATH_CLASSES.DS."Loader.php";
// ...then, activate it
if (Loader::activate() == false) die("Unable to activate class loader");

// Version information
include_once PATH_FRAMEWORK.DS."version.php";

// Check site configuration
$siteDirectory = PATH_SITES.DS.Configuration_CMS::$_siteName;
$siteCfgPath = Path::getSite("configuration.php");
if (file_exists($siteCfgPath)) {
	require_once $siteCfgPath;
	// Copy configuration to override
	$cfgFields = array("_dbHost","_dbName","_dbUser","_dbPassword","_siteTitle","_maintenanceMode");
	foreach ($cfgFields as $cfgField) {
		if (isset(Configuration_Site::$$cfgField)) {
			Configuration_CMS::$$cfgField = Configuration_Site::$$cfgField;
		}
	}
}
Configuration_CMS::$_siteTitle =
Settings::getInstance()->get("cms.site_title",Configuration_CMS::$_siteTitle);

// Fill in basic registry data
$registry = Registry::getInstance();
$registry->set("siteDirectory",$siteDirectory);
$registry->set("sitePathWeb","/sites/".Configuration_CMS::$_siteName);

$opt = Request::get("opt","mod");
if ($opt == "login") {
	// Login
	$redirectUrl = "index.php";
	if (defined("_ADMIN_MODE")) $redirectUrl = "administrator.php";
	if (!User::getInstance()->login()) $redirectUrl .= "?loginError=1";
	Util::redirect($redirectUrl);
}
else if ($opt == "logout") {
	// Logout
	User::getInstance()->logout();
}
else {
	if (defined("_ADMIN_MODE")) {
		// Check if user is administrator
		$user = User::getInstance();
		if (!$user->isAdmin()) {
			$user->loginForm();
		}
	}
	else if (Configuration_CMS::$_maintenanceMode) {
		// Check if user is administrator
		$user = User::getInstance();
		if (!$user->isAdmin()) {
			$user->maintenanceMessage();
		}
	}
	// Render page
	Renderer::getInstance()->render();
}

?>