<?php
	use \AF\Database;
	
	# Database Connection
	define('DATABASE_HOSTNAME',		'localhost');
	define('DATABASE_PORT',			3306);
	define('DATABASE_NAME',			'hausverwaltung');
	define('DATABASE_USERNAME',		'root');
	define('DATABASE_PASSWORD',		'');
	
	# Site Configuration
	define('SITE_NAME',				'Hausverwaltung');
	define('SITE_URL',				'http://yourdomain.com');
	
	define('UNIT_TYPES',			json_encode(array(
		array('value'	=> 'eg', 'name'	=> 'Erdgeschoss'),
		array('value'	=> '1e', 'name'	=> '1 Etage'),
		array('value'	=> '2e', 'name'	=> '2 Etage'),
		array('value'	=> '3e', 'name'	=> '3 Etage'),
		array('value'	=> '4e', 'name'	=> '4 Etage'),
		array('value'	=> '5e', 'name'	=> '5 Etage')
	)));
	
	# Functions
	function getUnitTypeName($name) {
		foreach(json_decode(UNIT_TYPES) AS $index => $type) {
			if($type->{'value'} === $name) {
				return $type->{'name'};
			}
		}
	}
	
	function getServiceById($id) {
		$service = Database::single('SELECT * FROM `af_services` WHERE `id`=:id', array(
			'id'	=> $id
		));
		
		return (empty($service->name) ? '' : $service->name);
	}
?>