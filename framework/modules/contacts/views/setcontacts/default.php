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
<center><h1>Контакты</h1></center>
<form action="administrator.php" method="post">
	<input type="hidden" name="mod" value="contacts" />
	<input type="hidden" name="act" value="saveContacts" />
	
	Адрес доставки для обратной связи:&nbsp;
	<input type="text" name="feedbackEmail" size="55" value="<?php echo $this->feedbackEmail; ?>" />
	
	<input type="submit" value="Сохранить" />
</form>
<?php if ($this->saved != 0) { ?>
<script type="text/javascript">alert("Изменения сохранены");</script>
<?php } ?>