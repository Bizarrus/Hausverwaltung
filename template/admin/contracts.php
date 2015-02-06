<?php
	use \AF\Bootstrap;
	use \AF\Database;
	
	$template->header();
	?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<h1>Aufträge <?php Bootstrap::link('Erstellen', $template->url('/admin/contract/new'), array('button' => 'info')); ?></h1>
					<p>Hier können Sie alle Aufträge im System administrieren.</p>
					<?php
						Bootstrap::alerts(true);
					?>
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Objekt</th>
								<th>Mieter</th>
								<th>Firma</th>
								<th>Aktionen</th>
							</tr>
						</thead>
						<tbody>
							<?php
								if(empty($contracts)) {
									?>
									<tr>
										<td colspan="5">
											<p class="text-center"><em>Es existieren derzeit keine Aufträge</em></p>
										</td>
									</tr>
									<?php
								} else {
									foreach($contracts AS $contract) {
										$object = Database::single('SELECT * FROM `af_rental_propertys` WHERE `id`=:id LIMIT 1', array(
											'id'	=> $contract->object_id
										));
										
										$unit = Database::single('SELECT * FROM `af_rental_units` WHERE `id`=:id LIMIT 1', array(
											'id'	=> $contract->rental_id
										));
										
										$customer = Database::single('SELECT * FROM `af_customers` WHERE `id`=:id LIMIT 1', array(
											'id'	=> $contract->customer_id
										));
										
										$company = Database::single('SELECT * FROM `af_companys` WHERE `id`=:id LIMIT 1', array(
											'id'	=> $contract->company_id
										));
										?>
											<tr>
												<td><?php print $contract->id; ?></td>
												<td><?php print $object->street_name; ?> <?php print $object->street_number; ?>, <?php print $object->city_zip; ?> <?php print $object->city_name; ?> (<?php print getUnitTypeName($unit->unit_type); ?>)</td>
												<td><?php if(empty($customer)) { ?> - Keiner - <?php } else { print $customer->firstname; ?> <?php print $customer->lastname; } ?></td>
												<td><?php print htmlentities((!empty($company) ? $company->name : $contract->company_id)); ?></td>
												<td>
													<?php
														Bootstrap::link('Bearbeiten', $template->url('/admin/contract/' . $contract->id), array(
															'button'	=> 'primary'
														));
														
														Bootstrap::link('Löschen', $template->url('/admin/contract/' . $contract->id . '/delete'), array(
															'button'	=> 'danger'
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
				</div>
			</div>
		</div>
	<?php
	$template->footer();
?>