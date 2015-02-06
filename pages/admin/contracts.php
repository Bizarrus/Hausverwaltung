<?php
	use \AF\Database;
	
	$contracts = Database::fetch('SELECT * FROM `af_contracts`');
	
	$template->assign('contracts', $contracts);
?>