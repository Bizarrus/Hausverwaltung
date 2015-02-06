<?php
	use \AF\Database;
	use \AF\Bootstrap;
	use \AF\Response;
	
	$result = Database::single('SELECT * FROM `af_contracts` WHERE `id`=:id LIMIT 1', array(
		'id'	=> $id
	));
	
	if($id == 'new') {
		$result							= (object) null;
		$result->id						= 'new';
		$result->time_created			= '';
		$result->time_contract			= '';
		$result->from					= -1;
		$result->company_id				= -1;
		$result->contact_id				= -1;
		$result->contact_telephone		= '';
		$result->contact_fax			= '';
		$result->contact_email			= '';
		$result->object_id				= -1;
		$result->rental_id				= -1;
		$result->customer_contact		= '';
		$result->informations			= '';
		$result->insurance				= 'NO';
		$result->customer_charging		= 'NO';
	} else if($action == 'delete') {
		Database::delete('af_contracts', array(
			'id'		=> $result->id
		));
		
		Bootstrap::alert('danger', 'Der Auftrag wurde gelöscht!');
		Response::redirect('/admin/contracts');
	}
	
	if(isset($_POST['action']) && $_POST['action'] == 'update') {
		var_dump($_POST);
		exit();
		$result->time_created		= (!isset($_POST['time_created']) || $result->time_created == $_POST['time_created'] ? $result->time_created : $_POST['time_created']);
		$result->time_contract		= (!isset($_POST['time_contract']) || $result->time_contract == $_POST['time_contract'] ? $result->time_contract : $_POST['time_contract']);
		$result->from				= (!isset($_POST['from']) || $result->from == $_POST['from'] ? $result->from : $_POST['from']);
		$result->company_id			= (!isset($_POST['autocomplete_reference_company']) || $result->company_id == $_POST['autocomplete_reference_company'] ? $result->company_id : $_POST['autocomplete_reference_company']);
		$result->contact_telephone	= (!isset($_POST['contact_telephone']) || $result->contact_telephone == $_POST['contact_telephone'] ? $result->contact_telephone : $_POST['contact_telephone']);
		$result->contact_fax		= (!isset($_POST['contact_fax']) || $result->contact_fax == $_POST['contact_fax'] ? $result->contact_fax : $_POST['contact_fax']);
		$result->contact_email		= (!isset($_POST['contact_email']) || $result->contact_email == $_POST['contact_email'] ? $result->contact_email : $_POST['contact_email']);
		$result->object_id			= (!isset($_POST['autocomplete_reference_rental_property']) || $result->object_id == $_POST['autocomplete_reference_rental_property'] ? $result->object_id : $_POST['autocomplete_reference_rental_property']);
		$result->rental_id			= (!isset($_POST['rental_id']) || $result->rental_id == $_POST['rental_id'] ? $result->rental_id : $_POST['rental_id']);
		$result->customer_contact	= (!isset($_POST['customer_contact']) || $result->customer_contact == $_POST['customer_contact'] ? $result->customer_contact : $_POST['customer_contact']);
		$result->informations		= (!isset($_POST['informations']) || $result->informations == $_POST['informations'] ? $result->informations : $_POST['informations']);
		$result->insurance			= isset($_POST['insurance']) ? 'YES' : 'NO';
		$result->customer_charging	= isset($_POST['customer_charging']) ? 'YES' : 'NO';
		
		if(!empty($_POST['autocomplete_reference_company_contact']) && is_numeric($_POST['autocomplete_reference_company_contact']) && $_POST['autocomplete_reference_company_contact'] > 0) {
			$result->contact_id		= $_POST['autocomplete_reference_company_contact'];
		} else if(!empty($_POST['contact_name'])) {
			$result->contact_id		= $_POST['contact_name'];
		} else {
			$result->contact_id		= -1;
		}
		
		$unit = Database::single('SELECT * FROM `af_rental_units` WHERE `id`=:id LIMIT 1', array(
			'id'	=> $result->rental_id
		));
		
		$result->customer_id = $unit->customer_id;
		
		try {
			if($id == 'new') {
				Database::insert('af_contracts', array(
					'time_created'		=> date_format(date_create_from_format('d.m.Y - H:i', $result->time_created), 'Y-m-d H:i:s'),
					'time_contract'		=> date_format(date_create_from_format('d.m.Y - H:i', $result->time_contract), 'Y-m-d H:i:s'),
					'from'				=> $result->from,
					'company_id'		=> $result->company_id,
					'contact_id'		=> $result->contact_id,
					'contact_telephone'	=> $result->contact_telephone,
					'contact_fax'		=> $result->contact_fax,
					'contact_email'		=> $result->contact_email,
					'object_id'			=> $result->object_id,
					'rental_id'			=> $result->rental_id,
					'customer_contact'	=> $result->customer_contact,
					'customer_id'		=> $result->customer_id,
					'informations'		=> $result->informations,
					'insurance'			=> $result->insurance,
					'customer_charging'	=> $result->customer_charging,
					'id'				=> NULL
				));
				
				Bootstrap::alert('success', 'Der Auftrag wurde erfolgreich angelegt.');
			} else {
				Database::update('af_contracts', 'id', array(
					'time_created'		=> date_format(date_create_from_format('d.m.Y - H:i', $result->time_created), 'Y-m-d H:i:s'),
					'time_contract'		=> date_format(date_create_from_format('d.m.Y - H:i', $result->time_contract), 'Y-m-d H:i:s'),
					'from'				=> $result->from,
					'company_id'		=> $result->company_id,
					'contact_id'		=> $result->contact_id,
					'contact_telephone'	=> $result->contact_telephone,
					'contact_fax'		=> $result->contact_fax,
					'contact_email'		=> $result->contact_email,
					'object_id'			=> $result->object_id,
					'rental_id'			=> $result->rental_id,
					'customer_contact'	=> $result->customer_contact,
					'customer_id'		=> $result->customer_id,
					'informations'		=> $result->informations,
					'insurance'			=> $result->insurance,
					'customer_charging'	=> $result->customer_charging,
					'id'				=> $result->id
				));
				
				Bootstrap::alert('success', 'Der Auftrag wurde erfolgreich geändert.');
			}
			
			Response::redirect('/admin/contracts');
		} catch(\Exception $e) {
			Bootstrap::alert('danger', $e->getMessage());
			Response::redirect('/admin/contracts');
		}
	}
	
	if($id != 'new') {
		$units = array();
		
		$object = Database::single('SELECT * FROM `af_rental_propertys` WHERE `id`=:id LIMIT 1', array(
			'id'	=> $result->object_id
		));
		
		$unit = Database::single('SELECT * FROM `af_rental_units` WHERE `id`=:id LIMIT 1', array(
			'id'	=> $result->rental_id
		));
		
		$customer = Database::single('SELECT * FROM `af_customers` WHERE `id`=:id LIMIT 1', array(
			'id'	=> $result->customer_id
		));
		
		$company = Database::single('SELECT * FROM `af_companys` WHERE `id`=:id LIMIT 1', array(
			'id'	=> $result->company_id
		));
		
		$contact = Database::single('SELECT * FROM `af_companys_contacts` WHERE `id`=:id LIMIT 1', array(
			'id'	=> $result->contact_id
		));
		
		$units_query	= Database::fetch('SELECT * FROM `af_rental_units` WHERE `property_id`=:property_id', array(
			'property_id'	=> $object->id
		));
		
		$user	= Database::single('SELECT * FROM `af_users` WHERE `id`=:id', array(
			'id'	=> $result->from
		));
		
		foreach($units_query AS $unit) {
			$value = '';
			
			if($unit->customer_id > 0) {
				$customer = Database::single('SELECT * FROM `af_customers` WHERE `id`=:id LIMIT 1', array(
					'id'	=> $unit->customer_id
				));
				
				if(!empty($customer)) {
					$value		= sprintf(' (%s %s)', $customer->firstname, $customer->lastname);
				}
			}
			
			$unit_object		= (object) null;
			$unit_object->value	= $unit->id;
			$unit_object->name	= getUnitTypeName($unit->unit_type) . $value;
			$units[]			= $unit_object;
		}
		
		$template->assign('company_name',	empty($company) ? $result->company_id : $company->name);
		$template->assign('contact_name',	empty($contact) ? $result->contact_id : $contact->firstname . ' ' . $contact->lastname);
		$template->assign('object_name',	$object->street_name . ' ' . $object->street_number . ', ' . $object->city_zip . ' ' . $object->city_name);
		$template->assign('units',			$units);
		$template->assign('username',		$user->username);
	}
	
	$template->assign('contract',	$result);
	$template->assign('id',			$id);
?>