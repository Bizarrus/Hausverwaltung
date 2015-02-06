<?php
	use \AF\Bootstrap;
	
	$template->header();
	?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<h1>Firmen <?php Bootstrap::link('Neue Firma', $template->url('/admin/company/new'), array('button' => 'info')); ?></h1>
					<p>Hier können Sie alle Firmen im System administrieren.</p>
					<?php
						Bootstrap::alerts(true);
					?>
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Dienstleistung</th>
								<th>Straße</th>
								<th>Kontakte</th>
								<th>Aktionen</th>
							</tr>
						</thead>
						<tbody>
							<?php
								if(empty($companys)) {
									?>
									<tr>
										<td colspan="4">
											<p class="text-center"><em>Es existieren keine Firmen</em></p>
										</td>
									</tr>
									<?php
								} else {
									foreach($companys AS $company) {
										?>
											<tr>
												<td><?php print $company->id; ?></td>
												<td><?php print htmlspecialchars($company->name); ?></td>
												<td><?php print getServiceById($company->service); ?></td>
												<td>
													<?php print htmlspecialchars($company->street_name); ?> <?php print htmlspecialchars($company->street_number); ?>
													<br /><?php print htmlspecialchars($company->city_zip); ?> <?php print htmlspecialchars($company->city_name); ?>
												</td>
												<td><?php print count($company->contacts); ?></td>
												<td>
													<?php
														Bootstrap::link('Bearbeiten', $template->url('/admin/company/' . $company->id), array(
															'button'	=> 'primary'
														));
														
														Bootstrap::link('Löschen', $template->url('/admin/company/' . $company->id . '/delete'), array(
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