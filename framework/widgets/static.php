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

class staticWidget extends Widget {
	
	public $pageId = 0;
	
	public function render() {
		$model = $this->getModel("page","static");
		if ($model->getElement($this->pageId)) {
			echo $model->html;
		}
	}

}

?>