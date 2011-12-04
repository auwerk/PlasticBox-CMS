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

class Uploader {

	protected $_destPath		= "";
	protected $_acceptedTypes	= array();

	public function __construct($destSubPath,$acceptedTypes=array()) {
		$this->_destPath = Util::getSiteUploadPath($destSubPath);
		$this->_acceptedTypes = $acceptedTypes;
	}
	
	public function upload($key,$keepNames=true) {
		$uploaded = array();
		foreach ($_FILES[$key]["tmp_name"] as $fileId=>$fileTmpPath) {
			if ($fileTmpPath != "") {
				$fileType = $_FILES[$key]["type"][$fileId];
				$fileName = $_FILES[$key]["name"][$fileId];
				if (!$keepNames) {
					$ext = Util::stripExtension($fileName);
					$fileName = md5(microtime()).".".$ext; 
				}
				if (in_array($fileType,$this->_acceptedTypes)) {
					// Accepted, upload
					$destPath = $this->_destPath.DS.$fileName;
					if (move_uploaded_file($fileTmpPath,$destPath)) {
						$upFile = new stdClass();
						$upFile->name = $fileName;
						$upFile->path = $destPath;
						$uploaded[$fileId] = $upFile;
						$r = "OK";
					}
					else $r = "ERROR";
					Debugger::getInstance()->log($fileTmpPath." => ".$destPath." [$r]");
				}
				else {
					Debugger::getInstance()->log("Rejected: ".$fileName);
				}
			}
		}
		return $uploaded;
	}
}

?>