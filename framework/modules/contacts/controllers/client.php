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

class clientController extends Controller {
	public function __construct($module) {
		parent::__construct($module);
		$this->_defaultView = "contacts";
	}

	public function showContacts($view) {
		$view->setLayout("wfeedback");
	}

	public function sendFeedback() {
		$senderName = Request::get("senderName","");
		$senderEmail = Request::get("senderEmail","");
		$senderPhone = Request::get("senderPhone","Не указан");
		$theme = Request::get("theme","");
		$text = Request::get("text","");

		if ($senderName != "" && $senderEmail != "" && $text != "" && $theme != "") {
			$to = Settings::getInstance()->get("contacts.feedback_email","");
			if ($to != "") {
				$from = $senderEmail;
				$headers = "From:".$from."\r\nContent-Type: text/plain; charset=utf-8";
				$theme = htmlspecialchars(trim($theme));
				$text = htmlspecialchars(trim($text))."\r\n\r\nТелефон для связи: ".$senderPhone;
				if (mail($to,$theme,$text,$headers)) {
					echo "<b>Сообщение отправлено.</b>";
				}
				else echo "<b>Сообщение не было отправлено. Ошибка</b>";
			}
			else echo "<b>Сообщение не было отправлено. Не указан адрес доставки</b>";
		}
		else {
			echo "<b>Сообщение не было отправлено. Попробуйте указать все данные</b>";
		}
	}

	public function requestCall() {
		$name = Request::get("name","");
		$phone = Request::get("phone","");
		$time = Request::get("time","");
		$day = Request::get("day","");

		if ($name != "" && $phone != "") {
			$theme = "Заказ звонка";
			$text = "Имя заказчика звонка: $name; Удобное время: $day, в $time";
			$to = Settings::getInstance()->get("contacts.feedback_email","");
			$from = Settings::getInstance()->get("contacts.system_email","");
			if ($to != "") {
				$headers = "From:".$from."\r\nContent-Type: text/plain; charset=utf-8";
				$theme = htmlspecialchars(trim($theme));
				$text = htmlspecialchars(trim($text))."\r\n\r\nТелефон для связи: ".$phone;
				if (mail($to,$theme,$text,$headers)) {
					echo "<b>Ваш заказ звонка принят.</b>";
				}
				else echo "<b>Ваш заказ звонка НЕ принят. Ошибка 1</b>";
			}
			else echo "<b>Ваш заказ звонка НЕ принят. Ошибка 2</b>";
		}
		else {
			echo "<b>Сообщение не было отправлено. Попробуйте указать все данные</b>";
		}
	}
}

?>