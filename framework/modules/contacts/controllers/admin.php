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

class adminController extends Controller {
	
	public function __construct($module) {
		parent::__construct($module);
		$this->_defaultView = "setcontacts";
		$this->_defaultAct = "show";
	}
	
	public function showSetcontacts($view) {
		$saved = Request::getInt("saved",0);
		
		$view->setLayout("default");
		$feedbackEmail = Settings::getInstance()->get("contacts.feedback_email","");
		$view->assign("feedbackEmail",$feedbackEmail);
		$view->assign("saved",$saved);
	}
	
	public function saveContacts() {
		$feedbackEmail = Request::get("feedbackEmail","");
		Settings::getInstance()->set("contacts.feedback_email",$feedbackEmail);
		$this->setRedirect("/administrator.php?mod=contacts&saved=1");
	}
}

?>