<?php
	use \AF\Auth;
	use \AF\Bootstrap;
	use \AF\Response;
	
	if(isset($_POST['action']) && $_POST['action'] == 'login') {
		try {
			if(Auth::login($_POST['username'], $_POST['password'])) {
				Response::redirect('/admin/overview');
			} else {
				Bootstrap::alert('danger', 'Login war fehlerhaft!');
			}
		} catch(\Exception $e) {
			Bootstrap::alert('danger', $e->getMessage());
		}
	}
?>