<?php
	use \AF\Database;
	
	$template->assign('users', Database::fetch('SELECT * FROM `af_users`'));
?>