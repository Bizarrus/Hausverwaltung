<?php
	use \AF\Database;
	use \AF\Bootstrap;
	use \AF\Response;
	
	$result = Database::single('SELECT * FROM `af_users` WHERE `id`=:id LIMIT 1', array(
		'id'	=> $id
	));
	
	if($id == 'new') {
		$result				= (object) null;
		$result->id			= 'new';
		$result->username	= '';
		$result->password	= '';
		$result->email		= '';
		$result->firstname	= '';
		$result->lastname	= '';
	} else if($action == 'delete') {
		Database::delete('af_users', array(
			'id'		=> $result->id
		));
		
		Bootstrap::alert('danger', 'Der Benutzername wurde gelöscht!');
		Response::redirect('/admin/users');
	}
	
	if(isset($_POST['action']) && $_POST['action'] == 'update') {
		$result->username	= (empty($_POST['username']) || $result->username == $_POST['username'] ? $result->username : $_POST['username']);
		$result->password	= (empty($_POST['password']) || $result->password == $_POST['password'] ? $result->password : MD5($_POST['password']));
		$result->email		= (empty($_POST['email']) || $result->email == $_POST['email'] ? $result->email : $_POST['email']);
		$result->firstname	= (empty($_POST['firstname']) || $result->firstname == $_POST['firstname'] ? $result->firstname : $_POST['firstname']);
		$result->lastname	= (empty($_POST['lastname']) || $result->lastname == $_POST['lastname'] ? $result->lastname : $_POST['lastname']);
		
		try {
			if($id == 'new') {
				Database::insert('af_users', array(
					'username'	=> $result->username,
					'password'	=> $result->password,
					'email'		=> $result->email,
					'firstname'	=> $result->firstname,
					'lastname'	=> $result->lastname,
					'id'		=> NULL
				));
				
				Bootstrap::alert('success', 'Der Benutzername wurde erfolgreich angelegt.');
			} else {
				Database::update('af_users', 'id', array(
					'username'	=> $result->username,
					'password'	=> $result->password,
					'email'		=> $result->email,
					'firstname'	=> $result->firstname,
					'lastname'	=> $result->lastname,
					'id'		=> $result->id
				));
				
				Bootstrap::alert('success', 'Der Benutzername wurde erfolgreich geändert.');
			}
			
			Response::redirect('/admin/users');
		} catch(\Exception $e) {
			Bootstrap::alert('danger', $e->getMessage());
			Response::redirect('/admin/users');
		}
	}
	
	
	$template->assign('user',	$result);
	$template->assign('id',		$id);
?>