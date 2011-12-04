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
	<input type="hidden" name="mod" value="static" />
	<input type="hidden" name="act" value="save" />
	<input type="hidden" name="id" value="<?php echo $this->id; ?>" />

	<table>
		<tr>
			<td>Алиас:</td>
			<td><input type="text" size="55" name="alias" value="<?php echo $this->alias; ?>" /></td>
		</tr>
		<tr>
			<td>Заголовок:</td>
			<td><input type="text" size="55" name="title" value="<?php echo $this->title; ?>" /></td>
		</tr>
	</table>	
	<?php Editor::place("html",$this->html); ?>
	<br /><input type="submit" value="Сохранить" />
</form>