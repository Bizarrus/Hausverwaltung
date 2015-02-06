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
					<h1><?php print ($id == 'new' ? 'Firma anlegen' : 'Firma bearbeiten'); ?></h1>
					<form role="form" action="<?php print Request::url(); ?>" method="post" autocomplete="off">
						<?php
							Bootstrap::input('Name', array(
								'type'	=> 'text',
								'name'	=> 'name',
								'value'	=> $company->name
							));
							
							Bootstrap::select('Dienstleistung', array(
								'name'		=> 'service',
								'value'		=> $company->service,
								'values'	=> $services
							));
						?>
						<div class="row">
							<div class="col-xs-8">
								<?php
									Bootstrap::input('Straße', array(
										'type'	=> 'text',
										'name'	=> 'street_name',
										'value'	=> $company->street_name
									));
								?>
							</div>
							<div class="col-xs-4">
								<?php
									Bootstrap::input('Hausnummer', array(
										'type'	=> 'text',
										'name'	=> 'street_number',
										'value'	=> $company->street_number
									));
								?>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-4">
								<?php
									Bootstrap::input('PLZ', array(
										'type'	=> 'text',
										'name'	=> 'city_zip',
										'value'	=> $company->city_zip
									));
								?>
							</div>
							<div class="col-xs-8">
								<?php
									Bootstrap::input('Ort', array(
										'type'	=> 'text',
										'name'	=> 'city_name',
										'value'	=> $company->city_name
									));
								?>
							</div>
						</div>
						<h2>Ansprechpartner <?php Bootstrap::button('Hinzufügen', 'info', array(
								'type'		=> 'button',
								'name'		=> 'add',
								'value'		=> 'contact',
								'container'	=> false
							)); ?></h2>
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Name</th>
									<th>Kontakt</th>
									<th>Aktionen</th>
								</tr>
							</thead>
							<tbody class="dynamic_contact">
								<?php
									if(empty($company->contacts)) {
										?>
											<tr>
												<tr class="table_empty">
													<p class="text-center"><em>Es existieren keine Ansprechpartner für diese Firma</em></p>
												</td>
											</tr>
										<?php
									} else {
										?>
											<tr class="table_empty hide">
												<td colspan="3">
													<p class="text-center"><em>Es existieren keine Ansprechpartner für diese Firma</em></p>
												</td>
											</tr>
										<?php
										foreach($company->contacts AS $index => $contact) {
											?>
												<tr>
													<td>
														<?php
															Bootstrap::input(NULL, array(
																'type'		=> 'hidden',
																'name'		=> 'contact[' . $index . '][id]',
																'value'		=> $contact->id,
																'container'	=> false
															));
														?>
														<div class="col-lg-6">
															<?php
																Bootstrap::input(NULL, array(
																	'type'			=> 'text',
																	'name'			=> 'contact[' . $index . '][firstname]',
																	'value'			=> $contact->firstname,
																	'placeholder'	=> 'Vorname'
																));
															?>
														</div>
														<div class="col-lg-6">
															<?php
																Bootstrap::input(NULL, array(
																	'type'			=> 'text',
																	'name'			=> 'contact[' . $index . '][lastname]',
																	'value'			=> $contact->lastname,
																	'placeholder'	=> 'Nachname'
																));
															?>
														</div>
													</td>
													<td>
														<?php
															$fields = array(
																'contact_email'					=> 'E-Mail',
																'contact_telephone_public'		=> 'Telefon',
																'contact_telephone_private'		=> 'Telefon (privat)',
																'contact_telephone_mobile'		=> 'Mobil',
																'contact_telephone_fax'			=> 'FAX'
															);
															
															foreach($fields AS $name => $title) {
																?>
																	<div class="row">
																		<div class="col-lg-6">
																			<label><?php print $title; ?></label>
																		</div>
																		<div class="col-lg-6">
																			<?php
																				Bootstrap::input(NULL, array(
																					'type'		=> 'text',
																					'name'		=> 'contact[' . $index . '][' . $name . ']',
																					'value'		=> $contact->{$name},
																					'container'	=> false
																				));
																			?>
																		</div>
																	</div>
																<?php
															}
														?>
													</td>
													<td>
														<?php
															Bootstrap::button('Löschen', 'danger', array(
																'type'		=> 'button',
																'name'		=> 'remove',
																'value'		=> 'contact',
																'container'	=> false
															));
														?>
													</td>
												</tr>
											<?php
										}
									}
								?>
							</tbody>
						</table>
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
		<script type="text/template" id="entry_contact">
			<tr>
				<td>
					<?php
						Bootstrap::input(NULL, array(
							'type'		=> 'hidden',
							'name'		=> 'contact[$index][id]',
							'value'		=> 'new',
							'container'	=> false
						));
					?>
					<div class="col-lg-6">
						<?php
							Bootstrap::input(NULL, array(
								'type'			=> 'text',
								'name'			=> 'contact[$index][firstname]',
								'value'			=> '',
								'placeholder'	=> 'Vorname'
							));
						?>
					</div>
					<div class="col-lg-6">
						<?php
							Bootstrap::input(NULL, array(
								'type'			=> 'text',
								'name'			=> 'contact[$index][lastname]',
								'value'			=> '',
								'placeholder'	=> 'Nachname'
							));
						?>
					</div>
				</td>
				<td>
					<?php
						$fields = array(
							'contact_email'					=> 'E-Mail',
							'contact_telephone_public'		=> 'Telefon',
							'contact_telephone_private'		=> 'Telefon (privat)',
							'contact_telephone_mobile'		=> 'Mobil',
							'contact_telephone_fax'			=> 'FAX'
						);
						
						foreach($fields AS $name => $title) {
							?>
								<div class="row">
									<div class="col-lg-6">
										<label><?php print $title; ?></label>
									</div>
									<div class="col-lg-6">
										<?php
											Bootstrap::input(NULL, array(
												'type'		=> 'text',
												'name'		=> 'contact[$index][' . $name . ']',
												'value'		=> '',
												'container'	=> false
											));
										?>
									</div>
								</div>
							<?php
						}
					?>
				</td>
				<td>
					<?php
						Bootstrap::button('Löschen', 'danger', array(
							'type'		=> 'button',
							'name'		=> 'remove',
							'value'		=> 'contact',
							'container'	=> false
						));
					?>
				</td>
			</tr>
		</script>
	<?php
	$template->footer();
?>