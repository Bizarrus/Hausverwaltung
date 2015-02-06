<?php
	use \AF\Database;
	use \AF\Bootstrap;
	use \AF\Response;
	
	$result = Database::single('SELECT * FROM `af_rental_propertys` WHERE `id`=:id LIMIT 1', array(
		'id'	=> $id
	));
	
	if($result == false) {
		$result = (object) null;
	}
	
	$result->units = Database::fetch('SELECT * FROM `af_rental_units` WHERE `property_id`=:property_id', array(
		'property_id'	=> $id
	));
	
	if($id == 'new') {
		$result				= (object) null;
		$result->id				= 'new';
		$result->street_name	= '';
		$result->street_number	= '';
		$result->city_zip		= '';
		$result->city_name		= '';
		$result->units			= array();
	} else if($action == 'delete') {
		Database::delete('af_rental_units', array(
			'property_id'	=> $result->id
		));
		
		Database::delete('af_rental_propertys', array(
			'id'		=> $result->id
		));
		
		Bootstrap::alert('danger', 'Das Mietobjekt wurde gelöscht!');
		Response::redirect('/admin/rental/propertys');
	}
	
	if(isset($_POST['action']) && $_POST['action'] == 'update') {
		$result->street_name	= (isset($_POST['street_name']) && $result->street_name == $_POST['street_name'] ? $result->street_name : $_POST['street_name']);
		$result->street_number	= (isset($_POST['street_number']) && $result->street_number == $_POST['street_number'] ? $result->street_number : $_POST['street_number']);
		$result->city_zip		= (isset($_POST['city_zip']) && $result->city_zip == $_POST['city_zip'] ? $result->city_zip : $_POST['city_zip']);
		$result->city_name		= (isset($_POST['city_name']) && $result->city_name == $_POST['city_name'] ? $result->city_name : $_POST['city_name']);
		$result->units			= (empty($_POST['unit']) ? array() : $_POST['unit']);
		
		try {
			if($id == 'new') {
				$unit_exists = array();
				
				$id = Database::insert('af_rental_propertys', array(
					'id'			=> NULL,
					'street_name'	=> $result->street_name,
					'street_number'	=> $result->street_number,
					'city_zip'		=> $result->city_zip,
					'city_name'		=> $result->city_name
				));
				
				foreach($result->units AS $index => $entry) {
					$data	= array(
						'id'						=> $result->units[$index]['id'],
						'customer_id'				=> $result->units[$index]['customer_id'],
						'information'				=> $result->units[$index]['informations'],
						'unit_type'					=> $result->units[$index]['unit_type'],
						'property_id'				=> $id
					);
					
					if($data['id'] == 'new') {
						$unit_exists[] = Database::insert('af_rental_units', $data);
					} else {
						$unit_exists[] = $data['id'];
						Database::update('af_rental_units', 'id', $data);
					}
				}
				
				Bootstrap::alert('success', 'Das Mietobjekt wurde erfolgreich angelegt.');
			} else {
				Database::update('af_rental_propertys', 'id', array(
					'id'			=> $result->id,
					'street_name'	=> $result->street_name,
					'street_number'	=> $result->street_number,
					'city_zip'		=> $result->city_zip,
					'city_name'		=> $result->city_name
				));
				
				if(count($result->units) > 0) {
					$unit_exists = array();
					
					foreach($result->units AS $index => $entry) {
						$data	= array(
							'id'						=> $result->units[$index]['id'],
							'customer_id'				=> $result->units[$index]['customer_id'],
							'information'				=> $result->units[$index]['informations'],
							'property_id'				=> $result->id,
							'unit_type'					=> $result->units[$index]['unit_type']
						);
						
						if($data['id'] == 'new') {
							$data['id']		= NULL;
							$unit_exists[]	= Database::insert('af_rental_units', $data);
						} else {
							$unit_exists[] = $data['id'];
							Database::update('af_rental_units', 'id', $data);
						}
					}
				
					// Delete all others
					Database::deleteWhereNot('af_rental_units', array(
						'id'			=> $unit_exists
					), array(
						'property_id'	=> $result->id
					));
				}
				
				Bootstrap::alert('success', 'Das Mietobjekt wurde erfolgreich geändert.');
			}
			
			Response::redirect('/admin/rental/propertys');
		} catch(\Exception $e) {
			Bootstrap::alert('danger', $e->getMessage());
			Response::redirect('/admin/rental/propertys');
		}
	}
	
	$customers			= Database::fetch('SELECT * FROM `af_customers`', array());
	$customers_options	= array();
	
	foreach($customers AS $index => $customer) {
		$customers_options[] = array(
			'name'	=> sprintf('%d: %s %s', $customer->id, $customer->firstname, $customer->lastname),
			'value'	=> $customer->id
		);
	}
	
	$template->assign('property',	$result);
	$template->assign('customers',	$customers_options);
	$template->assign('id',			$id);
?>