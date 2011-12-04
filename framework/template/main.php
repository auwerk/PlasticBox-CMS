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
// Stylesheets
$this->addStylesheet("main.css",true);
// Javascripts
$this->addJScript("generic.js",true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
	<head>
		<?php $this->renderHead(); ?>
	</head>
	<body>
		<div id="top-menu">
		<?php
		$modules = Module::getModulesList();
		foreach ($modules as $module) {
			$link = "administrator.php?mod=".$module->name;
			echo "<div class=\"top-menu-button\" onclick=\"chloc('$link');\">".$module->title."</div>";
		} 
		?>
		<div class="top-menu-button" onclick="chloc('administrator.php?opt=logout');">Выход</div>
		</div>
		<div id="content"><?php echo $this->moduleHTML; ?></div>
		<div id="footer-version"><?php echo Version::getHTML(); ?></div>
	</body>
</html>