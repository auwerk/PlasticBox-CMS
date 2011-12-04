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
<form action="administrator.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="mod" value="good" />
	<input type="hidden" name="act" value="save" />
	<input type="hidden" name="id"	value="<?php echo $this->id; ?>" />
	<table>
		<tr>
			<td>Наименование:</td>
			<td><input type="text" size="55" name="good_name"
				value="<?php echo $this->good_name; ?>" /></td>
		</tr>
		<tr>
			<td>ИД категории:</td>
			<td><input type="text" size="5" name="cat_id"
				value="<?php echo $this->cat_id; ?>" /></td>
		</tr>
		<tr>
			<td>Описание:</td>
			<td>
				<textarea name="description" rows="25" cols="30"><?php echo $this->description; ?></textarea>
			</td>
		</tr>
		<tr>
			<td>Доп. описание:</td>
			<td><?php Editor::place("add_description",$this->add_description); ?>
			</td>
		</tr>
	</table>
	<script type="text/javascript">
	function deleteImage(imgId) {
		$.ajax({
			url	: "/administrator.php?mod=good&act=deleteImage&imgid=" + imgId,
			type : "POST",
			success : function() {
				var inp = document.createElement("input");
				var brr = document.createElement("br");
				$(inp).attr("type","file");
				var inpNum = parseInt($("#imgCount").val());
				inpNum = inpNum + 1;
				$("#imgCount").val(inpNum);
				$(inp).attr("name","images[" + (inpNum - 1) + "]");
				$("div#imgInputs").append(inp);
				$("div#imgInputs").append(brr);
				$("div#imgDiv" + imgId).html("");
				alert("Удалено");
			}
		});
	}
	</script>
	
	<div style="margin-left: 10px;">
		<p>Цены:</p>
		<table>
			<tr><td>Цена1</td><td><input type="text" size="10" name="price1" value="<?php echo $this->price1; ?>" /></td></tr>
			<tr><td>Цена2</td><td><input type="text" size="10" name="price2" value="<?php echo $this->price2; ?>" /></td></tr>
			<tr><td>Цена3</td><td><input type="text" size="10" name="price3" value="<?php echo $this->price3; ?>" /></td></tr>
			<tr><td>Цена4</td><td><input type="text" size="10" name="price4" value="<?php echo $this->price4; ?>" /></td></tr>
			<tr><td>Цена5</td><td><input type="text" size="10" name="price5" value="<?php echo $this->price5; ?>" /></td></tr>
		</table>
	</div>

	<div style="margin-left: 10px;">
		<p>Изображения:</p>
	<?php 
	$imgInputs = 10;
	if ($this->id != 0) {
		foreach ($this->images as $img) {
			$imgPath = Util::getSiteUploadPathWeb("images/goods")."/".$img->filename;
			echo "<div id=\"imgDiv".$img->id."\"><img src=\"$imgPath\" />";
			echo "<button id=\"deleteImg".$img->id."\" onclick=\"deleteImage(".$img->id.");return false;\">Удалить</button></div>";
			$imgInputs--;
		}
	}
	echo "<div id=\"imgInputs\">";
	echo "<input type=\"hidden\" name=\"imgCount\" id=\"imgCount\" value=\"$imgInputs\" />";
	for ($ii = 0; $ii < $imgInputs; $ii++) {
		echo "<input type=\"file\" name=\"images[$ii]\" /><br />"; 
	}
	echo "</div>";
	?>
	</div>
	<?php
	if ($this->id != 0) {
		echo "<br /><table>";
		echo "<tr><th>Имя</th><th>Значение</th></tr>";
		foreach ($this->params as $param) {
			echo "<tr><td>".$param->name."</td>";
			echo "<td><input type=\"text\" name=\"".$param->id."\" value=\"".$param->value."\" /></td></tr>";
		}
		echo "</table>";
	}
	?>
	<br /><input type="submit" value="Сохранить" />
</form>