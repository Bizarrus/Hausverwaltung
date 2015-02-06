<?php
	use \AF\Request;
	use \AF\Auth;
	use \AF\Bootstrap;
	$template->header();
	?>
		<div class="contract-editor container-fluid">
			<form id="contract-form" action="<?php print Request::url(); ?>" method="post" autocomplete="off">
				<input type="hidden" name="current_step" value="customer" />
				<input type="hidden" name="api_url" value="<?php print $template->url('/ajax'); ?>" />
				<input type="hidden" name="company_id" value="-1" />
				<input type="hidden" name="contact_id" value="-1" />
				<?php
					Bootstrap::input(NULL, array(
						'type'		=> 'hidden',
						'name'		=> 'customer[id]',
						'value'		=> '',
						'container'	=> false
					));
				?>
				<div class="row">
					<div class="col-lg-12 text-center">
						<div class="wizard">
							<a class="tab_wizard tab_wizard_customer current"><span class="badge">1</span> Kunde</a>
							<a class="tab_wizard tab_wizard_object"><span class="badge">2</span> Mietobjekt</a>
							<a class="tab_wizard tab_wizard_service"><span class="badge">3</span> Dienstleistung</a>
							<a class="tab_wizard tab_wizard_company"><span class="badge">4</span> Firma</a> 
							<a class="tab_wizard tab_wizard_finish"><span class="badge">4</span> Fertig</a> 
						</div>
					</div>
				</div>
				<div class="tabs tab_customer">
					<div class="row">
						<div class="col-lg-12">
							<h3>Kunde / Mieter</h3>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<?php
								Bootstrap::input('Mieter / Kunde', array(
									'type'	=> 'text',
									'name'	=> 'customer',
									'value'	=> '',
									'data'	=> array(
										'autocomplete'	=> 'customer',
										'action'		=> $template->url('/ajax')
									)
								));
							?>
						</div>
					</div>
					<h3>Kontakt</h3>
					<p>Die Kontaktdaten werden automatisch ausgefüllt, sofern diese zuvor beim Kunden gesetzt wurden!</p>
					<div class="row">
						<div class="col-xs-3">
							<?php
								Bootstrap::input('Mail', array(
									'type'	=> 'text',
									'name'	=> 'customer[contact_email]',
									'value'	=> ''
								));
							?>
						</div>
						<div class="col-xs-3">
							<?php
								Bootstrap::input('Telefon', array(
									'type'	=> 'text',
									'name'	=> 'customer[contact_telephone_public]',
									'value'	=> ''
								));
							?>
						</div>
						<div class="col-xs-3">
							<?php
								Bootstrap::input('Telefon (privat)', array(
									'type'	=> 'text',
									'name'	=> 'customer[contact_telephone_private]',
									'value'	=> ''
								));
							?>
						</div>
						<div class="col-xs-3">
							<?php
								Bootstrap::input('Mobil', array(
									'type'	=> 'text',
									'name'	=> 'customer[contact_telephone_mobile]',
									'value'	=> ''
								));
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 back">
							<!-- Do Nothing -->
						</div>
						<div class="col-lg-6 next text-right">
							<?php
								Bootstrap::input(NULL, array(
									'type'		=> 'hidden',
									'name'		=> 'step_current',
									'value'		=> 'customer',
									'container'	=> false
								));
								
								Bootstrap::input(NULL, array(
									'type'		=> 'hidden',
									'name'		=> 'step_next',
									'value'		=> 'object',
									'container'	=> false
								));
								
								Bootstrap::button('Weiter', 'default', array(
									'type'		=> 'button',
									'name'		=> 'next_step',
									'value'		=> 'update',
									'container'	=> false
								));
							?>
						</div>
					</div>
				</div>
				<div class="tabs tab_object hide">
					<div class="row">
						<div class="col-lg-12">
							<h3>Mietobjekt</h3>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 objects_html">
							<div class="loading"></div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 back">
							<?php
								Bootstrap::input(NULL, array(
									'type'		=> 'hidden',
									'name'		=> 'step_current',
									'value'		=> 'object',
									'container'	=> false
								));
								
								Bootstrap::input(NULL, array(
									'type'		=> 'hidden',
									'name'		=> 'step_next',
									'value'		=> 'customer',
									'container'	=> false
								));
								
								Bootstrap::button('Zurück', 'primary', array(
									'type'		=> 'button',
									'name'		=> 'next_step',
									'value'		=> 'update',
									'container'	=> false
								));
							?>
						</div>
						<div class="col-lg-6 next text-right">
							<?php
								Bootstrap::input(NULL, array(
									'type'		=> 'hidden',
									'name'		=> 'step_current',
									'value'		=> 'object',
									'container'	=> false
								));
								
								Bootstrap::input(NULL, array(
									'type'		=> 'hidden',
									'name'		=> 'step_next',
									'value'		=> 'service',
									'container'	=> false
								));
								
								Bootstrap::button('Weiter', 'default', array(
									'type'		=> 'button',
									'name'		=> 'next_step',
									'value'		=> 'update',
									'container'	=> false
								));
							?>
						</div>
					</div>
				</div>
				<div class="tabs tab_service hide">
					<div class="row">
						<div class="col-lg-12">
							<h3>Dienstleistung</h3>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 services_html">
							<div class="loading"></div>
						</div>
					</div>
					<br />
					<br />
					<div class="row">
						<div class="col-lg-6 back">
							<?php
								Bootstrap::input(NULL, array(
									'type'		=> 'hidden',
									'name'		=> 'step_current',
									'value'		=> 'service',
									'container'	=> false
								));
								
								Bootstrap::input(NULL, array(
									'type'		=> 'hidden',
									'name'		=> 'step_next',
									'value'		=> 'object',
									'container'	=> false
								));
								
								Bootstrap::button('Zurück', 'primary', array(
									'type'		=> 'button',
									'name'		=> 'next_step',
									'value'		=> 'update',
									'container'	=> false
								));
							?>
						</div>
						<div class="col-lg-6 next text-right">
							<?php
								Bootstrap::input(NULL, array(
									'type'		=> 'hidden',
									'name'		=> 'step_current',
									'value'		=> 'service',
									'container'	=> false
								));
								
								Bootstrap::input(NULL, array(
									'type'		=> 'hidden',
									'name'		=> 'step_next',
									'value'		=> 'company',
									'container'	=> false
								));
								
								Bootstrap::button('Weiter', 'default', array(
									'type'		=> 'button',
									'name'		=> 'next_step',
									'value'		=> 'update',
									'container'	=> false
								));
							?>
						</div>
					</div>
				</div>
				<div class="tabs tab_company hide">
					<div class="row">
						<div class="col-lg-12">
							<h3>Firma</h3>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<?php
								Bootstrap::input('Firma', array(
									'type'	=> 'text',
									'name'	=> 'company',
									'value'	=> '',
									'data'	=> array(
										'autocomplete'	=> 'company',
										'action'		=> $template->url('/ajax'),
										'reference'		=> '-1',
										'additional'	=> array('service_id' => '$service_id')
									)
								));
								
								Bootstrap::input('Ansprechpartner', array(
									'type'	=> 'text',
									'name'	=> 'contact',
									'value'	=> '',
									'data'	=> array(
										'autocomplete'		=> 'company_contact',
										'action'			=> $template->url('/ajax'),
										'show_all'			=> true,
										'reference'			=> 'company',
										'reference_error'	=> 'Bitte wählen Sie zuerst eine Firma aus!',
										'bind'				=> 'company'
									)
								));
							?>
						</div>
					</div>
					<h3>Ansprechpartner</h3>
					<h3>Kontakt</h3>
					<p>Die Kontaktdaten werden automatisch ausgefüllt, sofern diese zuvor beim Ansprechpartner gesetzt wurden!</p>
					<div class="row">
						<div class="col-xs-3">
							<?php
								Bootstrap::input('Mail', array(
									'type'	=> 'text',
									'name'	=> 'company[contact_email]',
									'value'	=> ''
								));
							?>
						</div>
						<div class="col-xs-3">
							<?php
								Bootstrap::input('Telefon', array(
									'type'	=> 'text',
									'name'	=> 'company[contact_telephone_public]',
									'value'	=> ''
								));
							?>
						</div>
						<div class="col-xs-3">
							<?php
								Bootstrap::input('Telefon (privat)', array(
									'type'	=> 'text',
									'name'	=> 'company[contact_telephone_private]',
									'value'	=> ''
								));
							?>
						</div>
						<div class="col-xs-3">
							<?php
								Bootstrap::input('Mobil', array(
									'type'	=> 'text',
									'name'	=> 'company[contact_telephone_mobile]',
									'value'	=> ''
								));
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 back">
							<?php
								Bootstrap::input(NULL, array(
									'type'		=> 'hidden',
									'name'		=> 'step_current',
									'value'		=> 'company',
									'container'	=> false
								));
								
								Bootstrap::input(NULL, array(
									'type'		=> 'hidden',
									'name'		=> 'step_next',
									'value'		=> 'service',
									'container'	=> false
								));
								
								Bootstrap::button('Zurück', 'primary', array(
									'type'		=> 'button',
									'name'		=> 'next_step',
									'value'		=> 'update',
									'container'	=> false
								));
							?>
						</div>
						<div class="col-lg-6 next text-right">
							<?php
								Bootstrap::input(NULL, array(
									'type'		=> 'hidden',
									'name'		=> 'step_current',
									'value'		=> 'company',
									'container'	=> false
								));
								
								Bootstrap::input(NULL, array(
									'type'		=> 'hidden',
									'name'		=> 'step_next',
									'value'		=> 'finish',
									'container'	=> false
								));
								
								/*Bootstrap::button('Weiter', 'default', array(
									'type'		=> 'button',
									'name'		=> 'next_step',
									'value'		=> 'update',
									'container'	=> false
								));
							?><?php		*/						
								Bootstrap::button('Auftrag Anlegen', 'danger', array(
									'type'		=> 'submit',
									'name'		=> 'action',
									'value'		=> 'update',
									'container'	=> false
								));
							?>
						</div>
					</div>
				</div>
				<div class="tabs tab_finish hide">
					<div class="row">
						<div class="col-lg-12">
							<h3>Auftrag bestätigen</h3>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 back">
							<?php
								Bootstrap::input(NULL, array(
									'type'		=> 'hidden',
									'name'		=> 'step_current',
									'value'		=> 'finish',
									'container'	=> false
								));
								
								Bootstrap::input(NULL, array(
									'type'		=> 'hidden',
									'name'		=> 'step_next',
									'value'		=> 'company',
									'container'	=> false
								));
								
								Bootstrap::button('Zurück', 'primary', array(
									'type'		=> 'button',
									'name'		=> 'next_step',
									'value'		=> 'update',
									'container'	=> false
								));
							?>
						</div>
						<div class="col-lg-6 next text-right">
							<?php								
								Bootstrap::button('Auftrag Anlegen', 'danger', array(
									'type'		=> 'submit',
									'name'		=> 'action',
									'value'		=> 'update',
									'container'	=> false
								));
							?>
						</div>
					</div>
				</div>
			</form>
		</div>
	<?php
	$template->footer();
?>