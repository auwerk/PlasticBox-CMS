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

class Image {

	public static function generateThumb($srcPath,$dstPath,$dtw=75,$dth=75) {
		$settings = Settings::getInstance();
		$tw = $settings->get("thumbnail.width",$dtw);
		$th = $settings->get("thumbnail.height",$dth);
		
		$pathParts = explode(".",$srcPath);
		if (preg_match("/jpg|jpeg/",$pathParts[1])){
			$srcImg = imagecreatefromjpeg($srcPath);
		}
		if (preg_match("/png/",$pathParts[1])){
			$srcImg = imagecreatefrompng($srcPath);
		}

		$oldX = imageSX($srcImg);
		$oldY = imageSY($srcImg);
		if ($oldX > $oldY) {
			$thumbW = $tw;
			$thumbH = $oldY * ($th / $oldX);
		}
		if ($oldX < $oldY) {
			$thumbW = $oldX * ($tw / $oldY);
			$thumbH = $th;
		}
		if ($oldX == $oldY) {
			$thumbW = $tw;
			$thumbH = $th;
		}

		$dstImg = ImageCreateTrueColor($thumbW,$thumbH);
		imagecopyresampled($dstImg,$srcImg,0,0,0,0,$thumbW,$thumbH,$oldX,$oldY);

		if (preg_match("/png/",$pathParts[1])) {
			imagepng($dstImg,$dstPath);
		}
		else {
			imagejpeg($dstImg,$dstPath);
		}
		imagedestroy($dstImg);
		imagedestroy($srcImg);
	}

}

?>