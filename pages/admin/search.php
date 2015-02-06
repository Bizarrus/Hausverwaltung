<?php
	use \AF\Database;
	
	$query = $_GET['q'];
	
	$template->assign('query', $query);
?>