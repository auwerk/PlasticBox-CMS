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
$this->addStylesheet("login.css",true); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
	<head>
		<?php $this->renderHead("Вход в \"админку\""); ?>
	</head>
	<body>
		<div id="login-title">
			&quot;<?php echo Configuration_CMS::$_siteTitle; ?>&quot;
			&nbsp;-&nbsp;Администрирование
		</div>
		<div id="login-form">
			<div id="login-form-label">Вам необходимо представиться системе:</div>
			<form action="administrator.php" method="post">
				<input type="hidden" name="opt" value="login" />
				<table id="login-form-table">
					<tr>
						<td>Имя пользователя:</td>
						<td><input class="login-form-edit" type="text" name="user_name" value="" /></td>
					</tr>
					<tr>
						<td>Пароль:</td>
						<td><input class="login-form-edit" type="password" name="user_password" value="" /></td>
					</tr>
				</table>
				<div id="login-form-submit">
					<input type="submit" value="Войти" />
				</div>
				<?php if ($this->loginError != 0) { ?>
				<div id="login-form-error">Ошибка! Неверные имя пользователя/пароль</div>
				<?php } ?>
				<div id="login-form-version"><?php echo Version::getHTML(); ?></div>
			</form>
		</div>
	</body>
</html>