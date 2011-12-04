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
<?php if ($this->id != 0) { ?>
<div id="cat-header">
	<span id="cat-title"><?php echo $this->name; ?></span><hr />
	<span id="cat-description"><?php echo $this->description; ?></span>
</div>
<div id="cat-goods">
	<ul class="cat-good-list">
<?php 
foreach ($this->goods as $good) {
	$link = "/index.php?mod=good&view=flypage&id=".$good->id;
	echo "<li><a class=\"static-link\" href=\"$link\">".$good->name."</a></li>\n";
}
?>
	</ul>
</div>
<?php } else echo "<b>Ошибка: нет такой категории</b>"; ?>