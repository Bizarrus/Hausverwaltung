<?php
	use \AF\Bootstrap;
	
	$template->header();
	?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<h1>Mietobjekte <?php Bootstrap::link('Neues Objekt', $template->url('/admin/rental/property/new'), array('button' => 'info')); ?></h1>
					<p>Hier können Sie alle Mietobjekte im System administrieren.</p>
					<?php
						Bootstrap::alerts(true);
					?>
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Adresse</th>
								<th>Einheiten</th>
								<th>Aktionen</th>
							</tr>
						</thead>
						<tbody>
							<?php
								if(empty($propertys)) {
									?>
									<tr>
										<td colspan="4">
											<p class="text-center"><em>Es existieren keine Mietobjekte</em></p>
										</td>
									</tr>
									<?php
								} else {
									foreach($propertys AS $property) {
										?>
											<tr>
												<td><?php print $property->id; ?></td>
												<td>
													<?php print htmlspecialchars($property->street_name); ?> <?php print htmlspecialchars($property->street_number); ?>
													<br /><?php print htmlspecialchars($property->city_zip); ?> <?php print htmlspecialchars($property->city_name); ?>
												</td>
												<td>
													<?php print count($property->units); ?>
												</td>
												<td>
													<?php
														Bootstrap::link('Bearbeiten', $template->url('/admin/rental/property/' . $property->id), array(
															'button'	=> 'primary'
														));
														
														Bootstrap::link('Löschen', $template->url('/admin/rental/property/' . $property->id . '/delete'), array(
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