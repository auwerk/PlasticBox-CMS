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
?>
<div id="contacts-page">
<?php Widget::place("static",array("pageId"=>Settings::getInstance()->get("contacts.page_id",0))); ?>
</div>
<form action="index.php" method="post">
	<input type="hidden" name="mod" value="contacts" />
	<input type="hidden" name="act" value="sendFeedback" />
	
	<table style="width:99%;">
		<tr>
			<td>Ваше имя:</td>
			<td><input class="feedback-field" type="text" name="senderName" size="93" value="" /></td>
		</tr>
		<tr>
			<td>Ваш e-mail:</td>
			<td><input class="feedback-field" type="text" name="senderEmail" size="93" value="" /></td>
		</tr>
		<tr>
			<td>Телефон для связи:</td>
			<td><input type="text" name="senderPhone" size="25" value="" /></td>
		</tr>
		<tr>
			<td>Тема сообщения:</td>
			<td><input class="feedback-field" type="text" name="theme" size="93" value="" /></td>
		</tr>
		<tr>
			<td colspan="2">
				<textarea class="feedback-text" name="text" cols="82" rows="15"></textarea>
			</td>
		</tr>
	</table>
	
	<br /><input type="submit" value="Отправить" />
</form>