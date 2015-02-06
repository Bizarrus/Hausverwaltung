<?php
	use \AF\Database;
	use \AF\Bootstrap;
	use \AF\Response;
	
	$result = Database::single('SELECT * FROM `af_companys` WHERE `id`=:id LIMIT 1', array(
		'id'	=> $id
	));
	
	if($result == false) {
		$result = (object) null;
	}
	
	$services = array();
	foreach(Database::fetch('SELECT * FROM `af_services`') AS $index => $service) {
		$object			= (object) null;
		$object->name	= $service->name;
		$object->value	= $service->id;
		$services[]		= $object;
	}
	
	$result->contacts = Database::fetch('SELECT * FROM `af_companys_contacts` WHERE `company_id`=:company_id', array(
		'company_id'	=> $id
	));
	
	if($id == 'new') {
		$result				= (object) null;
		$result->id				= 'new';
		$result->name			= '';
		$result->service		= '';
		$result->street_name	= '';
		$result->street_number	= '';
		$result->city_zip		= '';
		$result->city_name		= '';
		$result->contacts		= array();
	} else if($action == 'delete') {
		Database::delete('af_companys_contacts', array(
			'company_id'	=> $result->id
		));
		
		Database::delete('af_companys', array(
			'id'		=> $result->id
		));
		
		Bootstrap::alert('danger', 'Die Firma wurde gelöscht!');
		Response::redirect('/admin/companys');
	}
	
	if(isset($_POST['action']) && $_POST['action'] == 'update') {
		$result->name			= (isset($_POST['name']) && $result->name == $_POST['name'] ? $result->name : $_POST['name']);
		$result->service		= (isset($_POST['service']) && $result->service == $_POST['service'] ? $result->service : $_POST['service']);
		$result->street_name	= (isset($_POST['street_name']) && $result->street_name == $_POST['street_name'] ? $result->street_name : $_POST['street_name']);
		$result->street_number	= (isset($_POST['street_number']) && $result->street_number == $_POST['street_number'] ? $result->street_number : $_POST['street_number']);
		$result->city_zip		= (isset($_POST['city_zip']) && $result->city_zip == $_POST['city_zip'] ? $result->city_zip : $_POST['city_zip']);
		$result->city_name		= (isset($_POST['city_name']) && $result->city_name == $_POST['city_name'] ? $result->city_name : $_POST['city_name']);
		$result->contacts		= (empty($_POST['contact']) ? array() : $_POST['contact']);
		
		try {
			if($id == 'new') {
				$id = Database::insert('af_companys', array(
					'id'			=> NULL,
					'name'			=> $result->name,
					'service'		=> $result->service,
					'street_name'	=> $result->street_name,
					'street_number'	=> $result->street_number,
					'city_zip'		=> $result->city_zip,
					'city_name'		=> $result->city_name
				));
				
				foreach($result->contacts AS $index => $entry) {
					$data	= array(
						'id'						=> $result->contacts[$index]['id'],
						'company_id'				=> $id,
						'firstname'					=> $result->contacts[$index]['firstname'],
						'lastname'					=> $result->contacts[$index]['lastname'],
						'contact_email'				=> $result->contacts[$index]['contact_email'],
						'contact_telephone_public'	=> $result->contacts[$index]['contact_telephone_public'],
						'contact_telephone_private'	=> $result->contacts[$index]['contact_telephone_private'],
						'contact_telephone_mobile'	=> $result->contacts[$index]['contact_telephone_mobile'],
						'contact_telephone_fax'		=> $result->contacts[$index]['contact_telephone_fax']
					);
					
					if($data['id'] == 'new') {
						$contact_exist[] = Database::insert('af_companys_contacts', $data);
					} else {
						$contact_exist[] = $data['id'];
						Database::update('af_companys_contacts', 'id', $data);
					}
				}
				
				Bootstrap::alert('success', 'Die Firma wurde erfolgreich angelegt.');
			} else {
				Database::update('af_companys', 'id', array(
					'id'			=> $result->id,
					'name'			=> $result->name,
					'service'		=> $result->service,
					'street_name'	=> $result->street_name,
					'street_number'	=> $result->street_number,
					'city_zip'		=> $result->city_zip,
					'city_name'		=> $result->city_name
				));
				
				// Delete Contacts
				if(count($result->contacts) == 0) {
					Database::delete('af_companys_contacts', array(
						'company_id'	=> $result->id
					));
				} else {
					$contact_exists = array();
					
					foreach($result->contacts AS $index => $entry) {
						$data	= array(
							'id'						=> $result->contacts[$index]['id'],
							'company_id'				=> $result->id,
							'firstname'					=> $result->contacts[$index]['firstname'],
							'lastname'					=> $result->contacts[$index]['lastname'],
							'contact_email'				=> $result->contacts[$index]['contact_email'],
							'contact_telephone_public'	=> $result->contacts[$index]['contact_telephone_public'],
							'contact_telephone_private'	=> $result->contacts[$index]['contact_telephone_private'],
							'contact_telephone_mobile'	=> $result->contacts[$index]['contact_telephone_mobile'],
							'contact_telephone_fax'		=> $result->contacts[$index]['contact_telephone_fax']
						);
						
						if($data['id'] == 'new') {
							$contact_exist[] = Database::insert('af_companys_contacts', $data);
						} else {
							$contact_exist[] = $data['id'];
							Database::update('af_companys_contacts', 'id', $data);
						}
					}
				
					// Delete all others
					Database::deleteWhereNot('af_companys_contacts', array(
						'id'			=> $contact_exist
					), array(
						'company_id'	=> $result->id
					));
				}
				
				Bootstrap::alert('success', 'Die Firma wurde erfolgreich geändert.');
			}
			
			Response::redirect('/admin/companys');
		} catch(\Exception $e) {
			Bootstrap::alert('danger', $e->getMessage());
			Response::redirect('/admin/companys');
		}
	}
	
	
	$template->assign('company',	$result);
	$template->assign('id',			$id);
	$template->assign('services',	$services);
?>