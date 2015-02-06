<?php
	use \AF\Request;
	use \AF\Bootstrap;
	
	$template->header();
	?>
		<div class="container container-fluid">
			<div class="row row-fluid">
				<div class="col-md-4 col-md-offset-4">
					<div class="panel centering">
						<h1 class="brand hidden-landscape"><span><?php print SITE_NAME; ?></span></h1>
						<form role="form" action="<?php print Request::url(); ?>" method="post">
							<?php
								Bootstrap::alerts(true);
						
								Bootstrap::input('Benutzername', array(
									'type'	=> 'text',
									'name'	=> 'username',
									'value'	=> ''
								));
								
								Bootstrap::input('Passwort', array(
									'type'	=> 'password',
									'name'	=> 'password',
									'value'	=> ''
								));
								
								Bootstrap::button('Login', 'success', array(
									'type'				=> 'submit',
									'name'				=> 'action',
									'value'				=> 'login',
									'container_classes'	=> array('text-right', 'no-padding', 'no-margin')
								));
							?>
						</form>
					</div>
				</div>
			</div>
		</div>
	<?php
	$template->footer();
?>