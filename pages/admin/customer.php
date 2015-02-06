<?php
	use \AF\Database;
	use \AF\Bootstrap;
	use \AF\Response;
	
	$result = Database::single('SELECT * FROM `af_customers` WHERE `id`=:id LIMIT 1', array(
		'id'	=> $id
	));
	
	if($result == false) {
		$result = (object) null;
	}
	
	$result->units = Database::fetch('SELECT * FROM `af_rental_units` WHERE `customer_id`=:customer_id', array(
		'customer_id'	=> $id
	));
	
	foreach($result->units AS $index => $unit) {
		$property = Database::single('SELECT * FROM `af_rental_propertys` WHERE `id`=:property_id', array(
			'property_id'	=> $unit->property_id
		));
		
		$result->units[$index]->property_id		= $property->id;
		$result->units[$index]->street_name		= $property->street_name;
		$result->units[$index]->street_number	= $property->street_number;
		$result->units[$index]->city_zip		= $property->city_zip;
		$result->units[$index]->city_name		= $property->city_name;
	}
	
	if($id == 'new') {
		$result								= (object) null;
		$result->id							= 'new';
		$result->firstname					= '';
		$result->lastname					= '';
		$result->contact_email				= '';
		$result->contact_telephone_public	= '';
		$result->contact_telephone_private	= '';
		$result->contact_telephone_mobile	= '';
		$result->units						= array();
	} else if($action == 'delete') {
		Database::delete('af_customers', array(
			'id'		=> $result->id
		));
		
		Database::reset('af_rental_units', 'customer_id', $result->id, -1);
		
		Bootstrap::alert('danger', 'Der Kunde wurde gelöscht!');
		Response::redirect('/admin/customers');
	}
	
	if(isset($_POST['action']) && $_POST['action'] == 'update') {
		$result->firstname					= (isset($_POST['firstname']) && $result->firstname == $_POST['firstname'] ? $result->firstname : $_POST['firstname']);
		$result->lastname					= (isset($_POST['lastname']) && $result->lastname == $_POST['lastname'] ? $result->lastname : $_POST['lastname']);
		$result->contact_email				= (isset($_POST['contact_email']) && $result->contact_email == $_POST['contact_email'] ? $result->contact_email : $_POST['contact_email']);
		$result->contact_telephone_public	= (isset($_POST['contact_telephone_public']) && $result->contact_telephone_public == $_POST['contact_telephone_public'] ? $result->contact_telephone_public : $_POST['contact_telephone_public']);
		$result->contact_telephone_private	= (isset($_POST['contact_telephone_private']) && $result->contact_telephone_private == $_POST['contact_telephone_private'] ? $result->contact_telephone_private : $_POST['contact_telephone_private']);
		$result->contact_telephone_mobile	= (isset($_POST['contact_telephone_mobile']) && $result->contact_telephone_mobile == $_POST['contact_telephone_mobile'] ? $result->contact_telephone_mobile : $_POST['contact_telephone_mobile']);
		
		try {
			if($id == 'new') {
				Database::insert('af_customers', array(
					'firstname'					=> $result->firstname,
					'lastname'					=> $result->lastname,
					'contact_email'				=> $result->contact_email,
					'contact_telephone_public'	=> $result->contact_telephone_public,
					'contact_telephone_private'	=> $result->contact_telephone_private,
					'contact_telephone_mobile'	=> $result->contact_telephone_mobile,
					'id'						=> NULL
				));
				
				Bootstrap::alert('success', 'Der Kunde wurde erfolgreich angelegt.');
			} else {
				Database::update('af_customers', 'id', array(
					'firstname'					=> $result->firstname,
					'lastname'					=> $result->lastname,
					'contact_email'				=> $result->contact_email,
					'contact_telephone_public'	=> $result->contact_telephone_public,
					'contact_telephone_private'	=> $result->contact_telephone_private,
					'contact_telephone_mobile'	=> $result->contact_telephone_mobile,
					'id'						=> $result->id
				));
				
				Bootstrap::alert('success', 'Der Kunde wurde erfolgreich geändert.');
			}
			
			try {
				if(isset($_POST['rentals']) && count($_POST['rentals']) > 0) {
					foreach($_POST['rentals'] AS $index => $data) {
						Database::query('UPDATE `af_rental_units`
						SET
							`customer_id`=' . $result->id . '
						WHERE
							`unit_type`=\'' . $data['unit_type'] . '\'
						AND
							`property_id`=' . $data['id'] . '
						');
					}
				}
			} catch(\Exception $e) {
				Bootstrap::alert('danger', $e->getMessage());
			}
			Response::redirect('/admin/customers');
		} catch(\Exception $e) {
			Bootstrap::alert('danger', $e->getMessage());
			Response::redirect('/admin/customers');
		}
	}
	
	
	$template->assign('customer',	$result);
	$template->assign('id',			$id);
?>