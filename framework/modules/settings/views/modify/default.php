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
	<input type="hidden" name="mod" value="settings" />
	<input type="hidden" name="act" value="save" />
	<input type="hidden" name="id" value="<?php echo $this->id; ?>" />
	
	<table>
		<tr>
			<td>Ключ:</td>
			<td>
				<input type="text" size="55" name="key" value="<?php echo $this->key; ?>" />
			</td>
		</tr>
		<tr>
			<td>Тип значения:</td>
			<td>
				<select name="type">
					<option value="1"<?php echo $this->vc_sel; ?>>Строка</option>
					<option value="2"<?php echo $this->int_sel; ?>>Число</option>
					<option value="3"<?php echo $this->text_sel; ?>>Текст</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Значение (строка):</td>
			<td>
				<input type="text" size="55" name="vc_value" value="<?php echo $this->vc_value; ?>" />
			</td>
		</tr>
		<tr>
			<td>Значение (число):</td>
			<td>
				<input type="text" size="11" name="int_value" value="<?php echo $this->int_value; ?>" />
			</td>
		</tr>
		<tr>
			<td>Значение (текст):</td>
			<td>
				<textarea name="text_value" cols="80" rows="25"><?php echo $this->text_value; ?></textarea>
			</td>
		</tr>
	</table>
	<input type="submit" value="Сохранить" />
</form>