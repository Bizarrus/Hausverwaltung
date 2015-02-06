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
					<h1><?php print ($id == 'new' ? 'Kunde anlegen' : 'Kunde bearbeiten'); ?></h1>
					<form role="form" action="<?php print Request::url(); ?>" method="post" autocomplete="off">
						<?php
							Bootstrap::input('Vorname', array(
								'type'	=> 'text',
								'name'	=> 'firstname',
								'value'	=> $customer->firstname
							));
							
							Bootstrap::input('Nachname', array(
								'type'	=> 'text',
								'name'	=> 'lastname',
								'value'	=> $customer->lastname
							));
							
							?><h2>Kontakt</h2><?php
							
							Bootstrap::input('E-Mail', array(
								'type'	=> 'text',
								'name'	=> 'contact_email',
								'value'	=> $customer->contact_email
							));
							
							Bootstrap::input('Telefon', array(
								'type'	=> 'text',
								'name'	=> 'contact_telephone_public',
								'value'	=> $customer->contact_telephone_public
							));
							
							Bootstrap::input('Telefon (privat)', array(
								'type'	=> 'text',
								'name'	=> 'contact_telephone_private',
								'value'	=> $customer->contact_telephone_private
							));
							
							Bootstrap::input('Mobil', array(
								'type'	=> 'text',
								'name'	=> 'contact_telephone_mobile',
								'value'	=> $customer->contact_telephone_mobile
							));
							
							?>
							<h2>Mietobjekte <?php Bootstrap::button('Hinzufügen', 'info', array(
								'type'		=> 'button',
								'name'		=> 'popup',
								'value'		=> 'rentals',
								'container'	=> false
							)); ?></h2>
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<th>Adresse</th>
											<!--<th>Information</th>-->
											<th>Aktionen</th>
										</tr>
									</thead>
									<tbody class="dynamic_rentals">
										<?php
											if(empty($customer->units)) {
												?>
													<tr class="table_empty">
														<td colspan="3">
															<p class="text-center"><em>Dieser Kunde hat derzeit keine Mietobjekte</em></p>
														</td>
													</tr>
												<?php
											} else {
												foreach($customer->units AS $index => $unit) {
													?>
														<tr class="table_empty hide">
															<td colspan="3">
																<p class="text-center"><em>Dieser Kunde hat derzeit keine Mietobjekte</em></p>
															</td>
														</tr>
														<tr>
															<td>
																<?php
																	Bootstrap::input(NULL, array(
																		'type'		=> 'hidden',
																		'name'		=> 'rentals[' . $index . '][id]',
																		'value'		=> $unit->id,
																		'container'	=> false
																	));
																	
																	Bootstrap::input(NULL, array(
																		'type'		=> 'hidden',
																		'name'		=> 'rentals[' . $index . '][unit_type]',
																		'value'		=> $unit->unit_type,
																		'container'	=> false
																	));
																	
																	print $unit->street_name; ?> <?php print $unit->street_number; ?>
																<br /><?php print $unit->city_zip; ?> <?php print $unit->city_name; ?>
															</td>
															<!--<td><?php print $unit->information; ?></td>-->
															<td>
																<?php																	
																	Bootstrap::link('Mietobjekt anzeigen', $template->url('/admin/rental/property/' . $unit->property_id), array('button' => 'info')); 
																
																	Bootstrap::button('Löschen', 'danger', array(
																		'type'		=> 'button',
																		'name'		=> 'remove',
																		'value'		=> 'rentals',
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
		<script type="text/template" id="entry_rentals">
			<tr>
				<td>
					<?php
						Bootstrap::input(NULL, array(
							'type'		=> 'hidden',
							'name'		=> 'rentals[$index][id]',
							'value'		=> '$id',
							'container'	=> false
						));

						Bootstrap::input(NULL, array(
							'type'		=> 'hidden',
							'name'		=> 'rentals[$index][unit_type]',
							'value'		=> '$unit_type',
							'container'	=> false
						));
					?>
					$street_name $street_number
					<br />$city_zip $city_name
				</td>
				<td>
					<?php
						Bootstrap::link('Mietobjekt anzeigen', $template->url('/admin/rental/property/$id'), array('button' => 'info')); 
						
						Bootstrap::button('Löschen', 'danger', array(
							'type'		=> 'button',
							'name'		=> 'remove',
							'value'		=> 'rentals',
							'container'	=> false
						));
					?>
				</td>
			</tr>
		</script>
		<div class="modal fade" id="popup_rentals" tabindex="-1" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Mietobjekt Suchen</h4>
					</div>
					<div class="modal-body">
						<form method="post" action="<?php print $template->url('/ajax'); ?>" class="ajax-search">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Suchen..." name="query" />
							</div>
							<input type="hidden" name="action" value="search" />
							<input type="hidden" name="type" value="rentals" />
						</form>
						<div class="ajax-result">
							<p class="bg-info">Bitte geben Sie einen Suchbegriff ein.</p>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Schließen</button>
					</div>
				</div>
			</div>
		</div>
	<?php
	$template->footer();
?>