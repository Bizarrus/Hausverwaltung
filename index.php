<?php
	define('PATH',	dirname(__FILE__));
	define('DS',	DIRECTORY_SEPARATOR);
	
	require_once(sprintf('%s/classes/core.class.php', PATH));
	new \AF\Core();
?>