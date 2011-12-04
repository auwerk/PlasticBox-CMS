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

define("DS",DIRECTORY_SEPARATOR);

// Root
define("PATH_ROOT"		,	dirname(__FILE__));
define("PATH_FRAMEWORK"	,	PATH_ROOT.DS."framework");

// Load framework
include_once PATH_FRAMEWORK.DS."startup.php";

?>