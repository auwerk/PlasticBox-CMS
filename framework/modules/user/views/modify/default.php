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
<form action="administrator.php" method="post">
	<input type="hidden" name="mod" value="user" />
	<input type="hidden" name="act" value="save" />
	<input type="hidden" name="id" value="<?php echo $this->id; ?>" />
	
	<table>
		<tr>
			<td>Логин:</td>
			<td><input type="text" size="55" name="name" value="<?php echo $this->name; ?>" /></td>
		</tr>
		<tr>
			<td>e-mail:</td>
			<td><input type="text" size="55" name="email" value="<?php echo $this->email; ?>" /></td>
		</tr>
		<tr>
			<td>Пароль:</td>
			<td><input type="password" size="55" name="password1" value="" /></td>
		</tr>
		<tr>
			<td>Подтверждение пароля:</td>
			<td><input type="password" size="55" name="password2" value="" /></td>
		</tr>
		<tr>
			<td>Является администратором:</td>
			<td><input type="checkbox" name="is_admin" <?php if ($this->is_admin) echo "checked=\"checked\" "?>/></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" value="Сохранить" /></td>
		</tr>
	</table>
</form>