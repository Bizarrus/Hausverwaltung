<?php
	use \AF\Database;
	
	$propertys = Database::fetch('SELECT * FROM `af_rental_propertys`');
	
	foreach($propertys AS $index => $property) {
		$propertys[$index]->units = Database::fetch('SELECT * FROM `af_rental_units` WHERE `property_id`=:property_id', array(
			'property_id'	=> $property->id
		));
	}
	
	$template->assign('propertys', $propertys);
?>