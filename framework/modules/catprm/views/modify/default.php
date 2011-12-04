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
	<input type="hidden" name="mod" value="catprm" />
	<input type="hidden" name="act" value="save" />
	<input type="hidden" name="id" value="<?php echo $this->id; ?>" />
	<table>
		<tr>
			<td>Наименование:</td>
			<td><input type="text" size="55" name="name" value="<?php echo $this->name; ?>" /></td>
		</tr>
		<tr>
			<td>ИД категории:</td>
			<td><input type="text" size="5" name="cat_id" value="<?php echo $this->cat_id; ?>" /></td>
		</tr>
	</table>
	<input type="submit" value="Сохранить" />
</form>