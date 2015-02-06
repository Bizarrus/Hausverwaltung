<?php
	use \AF\Request;
	use \AF\Bootstrap;
	use \AF\Database;
	$template->header();
	?>
		<div class="container-fluid">
			<div class="row">
				<?php
					Bootstrap::alerts(true);
				?>
				<div class="col-lg-12">
					<h1><?php print ($id == 'new' ? 'Mietobjekt anlegen' : 'Mietobjekt bearbeiten'); ?></h1>
					<form role="form" action="<?php print Request::url(); ?>" method="post" autocomplete="off">
						<div class="row">
							<div class="col-xs-8">
								<?php
									Bootstrap::input('Straße', array(
										'type'	=> 'text',
										'name'	=> 'street_name',
										'value'	=> $property->street_name
									));
								?>
							</div>
							<div class="col-xs-4">
								<?php
									Bootstrap::input('Hausnummer', array(
										'type'	=> 'text',
										'name'	=> 'street_number',
										'value'	=> $property->street_number
									));
								?>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">
								<?php
									Bootstrap::input('PLZ', array(
										'type'	=> 'text',
										'name'	=> 'city_zip',
										'value'	=> $property->city_zip
									));
								?>
							</div>
							<div class="col-xs-9">
								<?php
									Bootstrap::input('Ort', array(
										'type'	=> 'text',
										'name'	=> 'city_name',
										'value'	=> $property->city_name
									));
								?>
							</div>
						</div>
						<h2>Einheiten <?php Bootstrap::button('Hinzufügen', 'info', array(
								'type'		=> 'button',
								'name'		=> 'add',
								'value'		=> 'unit',
								'container'	=> false
							)); ?></h2>
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Kunde / Mieter</th>
									<th>Einheit</th>
									<th>Aktionen</th>
								</tr>
							</thead>
							<tbody class="dynamic_unit">
								<?php
									if(empty($property->units)) {
										?>
											<tr class="table_empty">
												<td colspan="3">
													<p class="text-center"><em>Es existieren keine Einheiten für dieses Mietobjekt</em></p>
												</td>
											</tr>
										<?php
									} else {
										?>
											<tr class="table_empty hide">
												<td colspan="3">
													<p class="text-center"><em>Es existieren keine Einheiten für dieses Mietobjekt</em></p>
												</td>
											</tr>
										<?php
										foreach($property->units AS $index => $unit) {
											?>
												<tr>
													<td>
														<?php
															Bootstrap::input(NULL, array(
																'type'		=> 'hidden',
																'name'		=> 'unit[' . $index . '][id]',
																'value'		=> $unit->id,
																'container'	=> false
															));
															
															if($unit->customer_id > 0) {
																$customer = Database::single('SELECT * FROM `af_customers` WHERE `id`=:id LIMIT 1', array(
																	'id'	=> $unit->customer_id
																));
																
																if(!empty($customer)) {
																	Bootstrap::input(NULL, array(
																		'type'		=> 'hidden',
																		'name'		=> 'unit[' . $index . '][customer_id]',
																		'value'		=> $unit->customer_id,
																		'container'	=> false
																	));
																	
																	Bootstrap::link(sprintf('%s %s', $customer->firstname, $customer->lastname), $template->url('/admin/customer/' . $unit->customer_id), array(
																		'blank' => true,
																		'data'	=> array(
																			'quickinfo'	=> 'customer',
																			'id'		=> $customer->id
																		)
																	)); 
																} else {
																	Bootstrap::input(NULL, array(
																		'type'		=> 'hidden',
																		'name'		=> 'unit[' . $index . '][customer_id]',
																		'value'		=> '-1',
																		'container'	=> false
																	));
																	
																	Bootstrap::label('- Keiner -');
																}
															} else {
																Bootstrap::input(NULL, array(
																	'type'		=> 'hidden',
																	'name'		=> 'unit[' . $index . '][customer_id]',
																	'value'		=> '-1',
																	'container'	=> false
																));
																
																Bootstrap::label('- Keiner -');
															}
														?>
													</td>
													<td>
														<?php
															Bootstrap::select(NULL, array(
																'name'		=> 'unit[' . $index . '][unit_type]',
																'value'		=> $unit->unit_type,
																'values'	=> json_decode(UNIT_TYPES),
																'container'	=> false
															));
														?>
													</td>
													<td>
														<?php
															Bootstrap::button('Löschen', 'danger', array(
																'type'		=> 'button',
																'name'		=> 'remove',
																'value'		=> 'unit',
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
		<script type="text/template" id="entry_unit">
			<tr>
				<td>
					<?php
						Bootstrap::input(NULL, array(
							'type'		=> 'hidden',
							'name'		=> 'unit[$index][id]',
							'value'		=> 'new',
							'container'	=> false
						));
						
						Bootstrap::input(NULL, array(
							'type'		=> 'hidden',
							'name'		=> 'unit[' . $index . '][customer_id]',
							'value'		=> '-1',
							'container'	=> false
						));
						
						Bootstrap::label('- Keiner -');
					?>
				</td>
				<td>
					<?php
						Bootstrap::select(NULL, array(
							'name'		=> 'unit[$index][unit_type]',
							'value'		=> '',
							'values'	=> json_decode(UNIT_TYPES),
							'container'	=> false
						));
					?>
				</td>
				<td>
					<?php
						Bootstrap::button('Löschen', 'danger', array(
							'type'		=> 'button',
							'name'		=> 'remove',
							'value'		=> 'unit',
							'container'	=> false
						));
					?>
				</td>
			</tr>
		</script>
	<?php
	$template->footer();
?>