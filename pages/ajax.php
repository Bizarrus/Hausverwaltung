<?php
	use \AF\Auth;
	use \AF\Response;
	use \AF\Database;
	use \AF\StringBuffer;
	use \AF\Bootstrap;
	
	if(!Auth::isLoggedIn()) {
		Response::redirect('/admin');
	}

	function highlight($text, $words, $tag = 'strong') {
		$words			= trim($words);
		$wordsArray		= explode(' ', $words);
		$text			= str_replace(array('<', '>'), array('°1°', '°2°'), $text);
		
		foreach($wordsArray AS $word) {
			if(strlen(trim($word)) != 0) {
				$text = preg_replace('/' . $word . '/Uis', '<' . $tag . '>\\0</' . $tag . '>', $text);
			}
		} 
		
		return str_replace(array('°1°', '°2°'), array('&lt;', '&gt;'), $text);
	} 

	Response::addHeader('Content-Type', 'application/json; charset=UTF-8');
	
	$response			= (object) null;
	$response->time		= time();
	$response->status	= 1;
	
	switch(isset($_POST['action']) ? $_POST['action'] : NULL) {
		case 'search':
			switch(isset($_POST['type']) ? $_POST['type'] : NULL) {
				case 'rentals':
					$response->query	= (isset($_POST['query']) ? $_POST['query'] : NULL);
					$response->result	= Database::fetch('SELECT * FROM `af_rental_propertys` WHERE `street_name` LIKE :query OR `street_number` LIKE :query OR `city_zip` LIKE :query OR `city_name` LIKE :query', array(
						'query'	=> sprintf('%%%s%%', $response->query)
					));
					$response->count	= count($response->result);
					$html				= new StringBuffer();
					
					$html->append('<table class="table table-striped table-hover">');
					$html->append('<thead>');
					$html->append('<tr>');
					$html->append('<th>ID</th>');
					$html->append('<th>Adresse</th>');
					$html->append('<th>Einheit</th>');
					$html->append('<th>Aktionen</th>');
					$html->append('</tr>');
					$html->append('</thead>');
					$html->append('<tbody>');
					
					foreach($response->result AS $index => $result) {
						$units			= array();
						$units_query	= Database::fetch('SELECT * FROM `af_rental_units` WHERE `property_id`=:property_id', array(
							'property_id'	=> $result->id
						));
						
						foreach($units_query AS $unit) {
							$additional			= '';
							
							if($unit->customer_id > 0) {
								$customer = Database::single('SELECT * FROM `af_customers` WHERE `id`=:id LIMIT 1', array(
									'id'	=> $unit->customer_id
								));
								
								if(!empty($customer)) {
									$additional		= sprintf(' (%s %s)', $customer->firstname, $customer->lastname);
								}
							}
							
							$object				= (object) null;
							$object->name		= getUnitTypeName($unit->unit_type) . $additional;
							$object->value		= $unit->unit_type;
							$object->enabled	= ($unit->customer_id > 0 ? false : true);
							$units[]			= $object;
						}
						
						$html->append('<tr>');
						$html->append('<td>%s</td>', $result->id);
						$html->append('<td>%s %s<br />%s %s</td>', $result->street_name, $result->street_number, $result->city_zip, $result->city_name);
						$html->append('<td>%s</td>', Bootstrap::select(NULL, array(
							'id'		=> 'unit_type_' . $index,
							'name'		=> 'unit_type_' . $index,
							'value'		=> '',
							'values'	=> $units,
							'return'	=> true
						)));
						
						$html->append('<td>%s</td>', Bootstrap::button('Hinzufügen', 'info', array(
							'type'		=> 'button',
							'name'		=> 'add',
							'value'		=> 'rentals',
							'container'	=> false,
							'return'	=> true,
							'data'		=> array(
								'$id'				=> $result->id,
								'$street_name'		=> $result->street_name,
								'$street_number'	=> $result->street_number,
								'$city_zip'			=> $result->city_zip,
								'$city_name'		=> $result->city_name,
								'$unit_type'		=> 'select#unit_type_' . $index . ' option:selected'
							)
						)));
						$html->append('</tr>');
					}
					
					$html->append('</tbody>');
					$html->append('</table>');
					
					$response->html		= $html->toString();
				break;
				default:
					$response->status	= 0;
					$response->message	= sprintf('Unknown Type "%s"!', isset($_POST['type']) ? $_POST['type'] : 'NULL');
				break;
			}
		break;
		case 'quickbox':
			switch(isset($_POST['type']) ? $_POST['type'] : NULL) {
				case 'customer':
					$response->id		= (isset($_POST['id']) ? $_POST['id'] : NULL);
					$response->html		= '';
					
					$customer			= Database::single('SELECT * FROM `af_customers` WHERE `id`=:id', array(
						'id'	=> $response->id
					));
					
					if(!empty($customer)) {
						$response->status	= 1;
						$response->html		.= '<div style="display:inline-block;float:left; padding:0 10px 0 0;border-right:1px solid #DDDDDD;min-height:80px;">';
						$response->html		.= '<label>' . htmlspecialchars($customer->firstname) . ' ' . htmlspecialchars($customer->lastname) . '</label>';
						$response->html		.= '</div>';
						$response->html		.= '<div style="display:inline-block;padding:0 0 0 10px;">';
						$response->html		.= '<strong style="display: inline-block; min-width: 110px;">E-Mail:</strong> ' . (empty($customer->contact_email) ? '<em>Nicht gesetzt</em>' : htmlspecialchars($customer->contact_email));
						$response->html		.= '<br /><strong style="display: inline-block; min-width: 110px;">Telefon:</strong> ' . (empty($customer->contact_telephone_private) ? '<em>Nicht gesetzt</em>' : htmlspecialchars($customer->contact_telephone_private));
						$response->html		.= '<br /><strong style="display: inline-block; min-width: 110px;">Telefon (privat):</strong> ' . (empty($customer->contact_telephone_private) ? '<em>Nicht gesetzt</em>' : htmlspecialchars($customer->contact_telephone_private));
						$response->html		.= '<br /><strong style="display: inline-block; min-width: 110px;">Mobil:</strong> ' . (empty($customer->contact_telephone_mobile) ? '<em>Nicht gesetzt</em>' : htmlspecialchars($customer->contact_telephone_mobile));
						$response->html		.= '</div>';
					}
				break;
				default:
					$response->status	= 0;
					$response->message	= sprintf('Unknown Type "%s"!', isset($_POST['type']) ? $_POST['type'] : 'NULL');
				break;
			}
		break;
		case 'json_search':
			switch(isset($_POST['type']) ? $_POST['type'] : NULL) {
				case 'objects':
					$response->query	= (isset($_POST['query']) ? $_POST['query'] : NULL);
					$response->result	= array();
					$units				= Database::fetch('SELECT * FROM `af_rental_units` WHERE `customer_id`=:customer_id', array(
						'customer_id'	=> $response->query
					));
					
					foreach($units AS $index => $unit) {
						$object			= Database::single('SELECT * FROM `af_rental_propertys` WHERE `id`=:id', array(
							'id'	=> $unit->property_id
						));
						
						$object->unit_id			= $unit->id;
						$object->customer_id		= $unit->customer_id;
						$object->unit_type			= $unit->unit_type;
						$object->unit_type_name		= getUnitTypeName($unit->unit_type);
						$object->information		= $unit->information;
						$response->result[]			= $object;
					}
					
					$response->count	= count($response->result);					
				break;
				case 'service':
					$response->result	= Database::fetch('SELECT * FROM `af_services`');
					$response->count	= count($response->result);	
				break;
				default:
					$response->status	= 0;
					$response->message	= sprintf('Unknown Type "%s"!', isset($_POST['type']) ? $_POST['type'] : 'NULL');
				break;
			}
		break;
		case 'autocomplete':
			switch(isset($_POST['type']) ? $_POST['type'] : NULL) {
				case 'customer':
					$response->query	= (isset($_POST['query']) ? $_POST['query'] : NULL);
					$response->result	= Database::fetch('SELECT
						*
					FROM
						`af_customers`
					WHERE
						`firstname` LIKE :query
					OR
						`lastname` LIKE :query
					OR
						`contact_email` LIKE :query
					OR
						`contact_telephone_private` LIKE :query
					OR
						`contact_telephone_mobile` LIKE :query
					OR
						`contact_telephone_public` LIKE :query
					', array(
						'query'	=> sprintf('%%%s%%', $response->query)
					));
					
					$response->count	= count($response->result);
					$html				= new StringBuffer();
					
					foreach($response->result AS $index => $result) {
						$contacts = array(
							'customer[id]'							=> $result->id,
							'customer[contact_telephone_public]'	=> $result->contact_telephone_public,
							'customer[contact_telephone_private]'	=> $result->contact_telephone_private,
							'customer[contact_telephone_mobile]'	=> $result->contact_telephone_mobile,
							'customer[contact_email]'				=> $result->contact_email
						);
						
						$html->append('<div class="autocomplete-result" data-replace="%s %s" data-reference="%d" data-type="%s" data-fillout="%s">', $result->firstname, $result->lastname, $result->id, 'customer', str_replace('"', '\'', json_encode($contacts)));
						$html->append('<label>%s %s</label>', highlight($result->firstname, $response->query), highlight($result->lastname, $response->query));
						$html->append('<i>%s</i>', highlight($result->contact_email, $response->query));
						$html->append('</div>');
					}
					
					$response->html		= $html->toString();
				break;
				case 'company':
					$response->query		= (isset($_POST['query']) ? $_POST['query'] : NULL);
					$response->service_id	= (isset($_POST['service_id']) ? $_POST['service_id'] : NULL);
					$response->result		= Database::fetch('SELECT
						*
					FROM
						`af_companys`
					WHERE
						`name` LIKE :query
					OR
						`street_name` LIKE :query
					OR
						`street_number` LIKE :query
					OR
						`city_zip` LIKE :query
					OR
						`city_name` LIKE :query
					', array(
						'query'	=> sprintf('%%%s%%', $response->query)
					));
					
					$response->count	= count($response->result);
					$html				= new StringBuffer();
					
					foreach($response->result AS $index => $result) {
						if(!empty($response->service_id) && $response->service_id != $result->service) {
							unset($response->result[$index]);
							$response->count--;
						}
						
						if(empty($response->service_id) || $response->service_id == $result->service) {
							$html->append('<div class="autocomplete-result" data-replace="%s" data-reference="%d" data-type="%s" data-fillout="%s">', $result->name, $result->id, 'company', str_replace('"', '\'', json_encode(array(
								'company_id'	=> $result->id
							))));
						
							$html->append('<label>%s</label>', highlight($result->name, $response->query));
							$html->append('<i>%s</i>', getServiceById($result->service));
							$html->append('</div>');
						}
					}
					
					$response->html		= $html->toString();
				break;
				case 'company_contact':
					$response->query	= (isset($_POST['query']) ? $_POST['query'] : NULL);
					$response->result	= Database::fetch('SELECT
						*
					FROM
						`af_companys_contacts`
					WHERE (
							`firstname` LIKE :query
						OR
							`lastname` LIKE :query
						OR
							`contact_email` LIKE :query
						OR
							`contact_telephone_private` LIKE :query
						OR
							`contact_telephone_mobile` LIKE :query
						OR
							`contact_telephone_public` LIKE :query
						OR
							`contact_telephone_fax` LIKE :query
						) AND `company_id`=:company_id
					', array(
						'query'			=> sprintf('%%%s%%', $response->query),
						'company_id'	=> (isset($_POST['reference']) ? $_POST['reference'] : -1)
					));
					
					$response->count	= count($response->result);
					$html				= new StringBuffer();
					
					foreach($response->result AS $index => $result) {
						$contacts = array(
							'company[contact_telephone_public]'		=> $result->contact_telephone_public,
							'company[contact_telephone_private]'	=> $result->contact_telephone_private,
							'company[contact_telephone_mobile]'		=> $result->contact_telephone_mobile,
							'company[contact_telephone_fax]'		=> $result->contact_telephone_fax,
							'company[contact_email]'				=> $result->contact_email
						);
						$html->append('<div class="autocomplete-result" data-replace="%s" data-reference="%d" data-type="%s" data-fillout="%s">', $result->firstname . ' ' . $result->lastname, $result->id, 'company_contact', str_replace('"', '\'', json_encode($contacts)));
						$html->append('<label>%s</label>', highlight($result->firstname . ' ' . $result->lastname, $response->query));
						$html->append('<i>%s</i>', highlight($result->contact_email, $response->query));
						$html->append('</div>');
					}
					
					$response->html		= $html->toString();
				break;
				case 'rental_property':
					$response->query	= (isset($_POST['query']) ? $_POST['query'] : NULL);
					$response->result	= Database::fetch('SELECT
						*
					FROM
						`af_rental_propertys`
					WHERE
						`street_name` LIKE :query
					OR
						`street_number` LIKE :query
					OR
						`city_zip` LIKE :query
					OR
						`city_name` LIKE :query
					', array(
						'query'	=> sprintf('%%%s%%', $response->query)
					));
					
					$response->count	= count($response->result);
					$html				= new StringBuffer();
					
					foreach($response->result AS $index => $result) {
						$units			= array();
						$units_query	= Database::fetch('SELECT * FROM `af_rental_units` WHERE `property_id`=:property_id', array(
							'property_id'	=> $result->id
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
							
							$units[$unit->id] = getUnitTypeName($unit->unit_type) . $value;
						}
						
						$html->append('<div class="autocomplete-result" data-replace="%s %s, %s %s" data-reference="%d" data-type="%s" data-fillout="%s">', $result->street_name, $result->street_number, $result->city_zip, $result->city_name, $result->id, 'rental_property', str_replace('"', '\'', json_encode(array('rental_id' => $units))));
						$html->append('<label>%s</label>', highlight(sprintf('%s %s, %s %s', $result->street_name, $result->street_number, $result->city_zip, $result->city_name), $response->query));
						$html->append('<i>%s</i>', '0');
						$html->append('</div>');
					}
					
					$response->html		= $html->toString();
				break;
				
				default:
					$response->status	= 0;
					$response->message	= sprintf('Unknown Type "%s"!', isset($_POST['type']) ? $_POST['type'] : 'NULL');
				break;
			}
		break;
		default:
			$response->status	= 0;
			$response->message	= sprintf('Unknown Action "%s"!', isset($_POST['action']) ? $_POST['action'] : 'NULL');
		break;
	}
	
	Response::header();
	print json_encode($response);
?>