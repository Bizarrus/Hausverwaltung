<?php
	use \AF\Request;
	use \AF\Auth;
	use \AF\Bootstrap;
	$template->header();
	?>
		<div class="container-fluid">
			<div class="row">
				<?php
					Bootstrap::alerts(true);
				?>
				<div class="col-lg-12 text-center">
					<div class="wizard">
						<a class="current"><span class="badge">1</span> Kunde</a>
						<a><span class="badge">2</span> Mietobjekt</a>
						<a><span class="badge">3</span> Dienstleistung</a>
						<a><span class="badge">4</span> Firma</a> 
					</div>
					
					
					<h1><?php print ($id == 'new' ? 'Auftrag anlegen' : 'Auftrag bearbeiten'); ?></h1>
					<form role="form" action="<?php print Request::url(); ?>" method="post" autocomplete="off">
							<div class="row">
								<div class="col-xs-12">
									<?php
										Bootstrap::datetime('Mängelmeldung am', array(
											'format'	=> 'DD.MM.YYYY - HH:mm',
											'name'		=> 'time_created',
											'clear'		=> false,
											'value'		=> $id == 'new' || !strtotime($contract->time_contract) ? date('d.m.Y - H:i') : date_format(date_create_from_format('Y-m-d H:i:s', $result->time_created), 'd.m.Y - H:i')
										));
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-8">
									<?php
										Bootstrap::datetime('Auftrag angenommen am', array(
											'format'	=> 'DD.MM.YYYY - HH:mm',
											'name'		=> 'time_contract',
											'clear'		=> true,
											'value'		=> !strtotime($contract->time_contract) ? '' : date_format(date_create_from_format('Y-m-d H:i:s', $result->time_contract), 'd.m.Y - H:i')
										));
									?>
								</div>
								<div class="col-xs-4">
									<?php
										Bootstrap::input(NULL, array(
											'type'		=> 'hidden',
											'name'		=> 'from',
											'value'		=> $id == 'new' ? Auth::getID() : $contract->from,
											'container'	=> false
										));
										
										Bootstrap::staticText('von', $id == 'new' ? Auth::getUsername() : $username);
									?>
								</div>
							</div>
							<hr />
							<?php
								Bootstrap::input('Firma', array(
									'type'	=> 'text',
									'name'	=> 'company_id',
									'value'	=> (!is_numeric($contract->company_id) || $contract->company_id > 0 ? $company_name : ''),
									'data'	=> array(
										'autocomplete'	=> 'company',
										'action'		=> $template->url('/ajax'),
										'reference'		=> $contract->company_id
									)
								));
							?>
							<?php
								Bootstrap::input('Ansprechpartner', array(
									'type'	=> 'text',
									'name'	=> 'contact_name',
									'value'	=> (!is_numeric($contract->contact_id) || $contract->contact_id > 0 ? $contact_name : ''),
									'data'	=> array(
										'autocomplete'		=> 'company_contact',
										'action'			=> $template->url('/ajax'),
										'reference'			=> $contract->contact_id,
										'reference_error'	=> 'Bitte wählen Sie zuerst eine Firma aus!',
										'bind'				=> 'company'
									)
								));
							?>
							<div class="row">
								<div class="col-xs-6">
									<?php
										Bootstrap::input('Telefon', array(
											'type'	=> 'text',
											'name'	=> 'contact_telephone',
											'value'	=> $contract->contact_telephone
										));
									?>
								</div>
								<div class="col-xs-3">
									<?php
										Bootstrap::input('Fax', array(
											'type'	=> 'text',
											'name'	=> 'contact_fax',
											'value'	=> $contract->contact_fax
										));
									?>
								</div>
								<div class="col-xs-3">
									<?php
										Bootstrap::input('Mail', array(
											'type'	=> 'text',
											'name'	=> 'contact_email',
											'value'	=> $contract->contact_email
										));
									?>
								</div>
							</div>
							<hr />
							<?php
							Bootstrap::input('Objekt', array(
								'type'	=> 'text',
								'name'	=> 'object',
								'value'	=> ($contract->object_id > 0 ? $object_name : ''),
								'data'	=> array(
									'autocomplete'	=> 'rental_property',
									'action'		=> $template->url('/ajax'),
									'reference'		=> $contract->object_id
								)
							));
							
							Bootstrap::select('Wohnung', array(
								'type'		=> 'text',
								'name'		=> 'rental_id',
								'value'		=> $contract->rental_id,
								'values'	=> $id == 'new' ? array() : $units
							));
							
							Bootstrap::input('Kontakt', array(
								'type'	=> 'text',
								'name'	=> 'customer_contact',
								'value'	=> $contract->customer_contact
							));
							
							?>
							<hr />
							<?php
							Bootstrap::textarea('Sachlage', array(
								'type'	=> 'text',
								'name'	=> 'informations',
								'value'	=> $contract->informations
							));
							
							?>
							<div class="row">
								<div class="col-xs-7">
									<?php
										Bootstrap::label('Versicherung');
									?>
								</div>
								<div class="col-xs-5">
									<?php
										Bootstrap::toggle(null, array(
											'name'		=> 'insurance',
											'enabled'	=> $contract->insurance == 'YES'
										));
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-7">
									<?php
										Bootstrap::label('Mieteranlastung');
									?>
								</div>
								<div class="col-xs-5">
									<?php
										Bootstrap::toggle(null, array(
											'name'		=> 'customer_charging',
											'enabled'	=> $contract->customer_charging == 'YES'
										));
									?>
								</div>
							</div>
							<?php
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