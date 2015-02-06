<?php
	use \AF\Database;
	
	$customers = Database::fetch('SELECT * FROM `af_customers`');
	
	foreach($customers AS $index => $customer) {
		$customers[$index]->units = Database::fetch('SELECT * FROM `af_rental_units` WHERE `customer_id`=:customer_id', array(
			'customer_id'	=> $customer->id
		));
	}
	
	$template->assign('customers', $customers);
?>