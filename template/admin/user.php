<?php
	use \AF\Request;
	use \AF\Bootstrap;
	$template->header();
	?>
		<div class="container-fluid">
			<div class="row">
				<?php
					Bootstrap::alerts(true);
				?>
				<div class="col-lg-12">
					<h1><?php print ($id == 'new' ? 'Benutzer anlegen' : 'Benutzer bearbeiten'); ?></h1>
					<form role="form" action="<?php print Request::url(); ?>" method="post" autocomplete="off">
						<div class="row">
							<div class="col-lg-6">
								<?php
									Bootstrap::input('Vorname', array(
										'type'			=> 'text',
										'name'			=> 'firstname',
										'value'			=> $user->firstname
									));
								?>
							</div>
							<div class="col-lg-6">
								<?php
									Bootstrap::input('Nachname', array(
										'type'			=> 'text',
										'name'			=> 'lastname',
										'value'			=> $user->lastname
									));
								?>
							</div>
						</div>
						<h3>Account</h3>
						<?php
							Bootstrap::input('Benutzername', array(
								'type'	=> 'text',
								'name'	=> 'username',
								'value'	=> $user->username
							));
							
							Bootstrap::input('Passwort', array(
								'type'			=> 'password',
								'name'			=> 'password',
								'value'			=> '',
								'placeholder'	=> ($id == 'new' ? '' : 'Neues Passwort setzen...')
							));
						?>
						<h3>Kontakt</h3>
						<?php
							Bootstrap::input('E-Mail', array(
								'type'			=> 'text',
								'name'			=> 'email',
								'value'			=> $user->email
							));
							
							Bootstrap::button('Speichern', 'primary', array(
								'type'	=> 'submit',
								'name'	=> 'action',
								'value'	=> 'update'
							));
						?>
					</form>
				</div>
			</div>
		</div>
	<?php
	$template->footer();
?>