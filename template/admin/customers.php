<?php
	use \AF\Bootstrap;
	
	$template->header();
	?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<h1>Kunden <?php Bootstrap::link('Neuen Kunden', $template->url('/admin/customer/new'), array('button' => 'info')); ?></h1>
					<p>Hier können Sie alle Kunden im System administrieren.</p>
					<?php
						Bootstrap::alerts(true);
					?>
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Straße</th>
								<th>Mieteinheiten</th>
								<th>Aktionen</th>
							</tr>
						</thead>
						<tbody>
							<?php
								if(empty($customers)) {
									?>
									<tr>
										<td colspan="4">
											<p class="text-center"><em>Es existieren keine Kunden</em></p>
										</td>
									</tr>
									<?php
								} else {
									foreach($customers AS $customer) {
										?>
											<tr>
												<td><?php print $customer->id; ?></td>
												<td><?php print htmlspecialchars($customer->firstname); ?> <?php print htmlspecialchars($customer->lastname); ?></td>
												<td>
													<?php
														if(!empty($customer->contact_email)) {
															?>
																<div class="row">
																	<div class="col-lg-6">
																		<label>E-Mail:</label>
																	</div>
																	<div class="col-lg-6">
																		<?php print htmlspecialchars($customer->contact_email); ?>
																	</div>
																</div>
															<?php
														}
														
														if(!empty($customer->contact_telephone_public)) {
															?>
															<div class="row">
																<div class="col-lg-6">
																	<label>Telefon:</label>
																</div>
																<div class="col-lg-6">
																	<?php print htmlspecialchars($customer->contact_telephone_public); ?>
																</div>
															</div>
															<?php
														}
														
														if(!empty($customer->contact_telephone_private)) {
															?>
															<div class="row">
																<div class="col-lg-6">
																	<label>Telefon (privat);</label>
																</div>
																<div class="col-lg-6">
																	<?php print htmlspecialchars($customer->contact_telephone_private); ?>
																</div>
															</div>
															<?php
														}
														
														if(!empty($customer->contact_telephone_mobile)) {
															?>
															<div class="row">
																<div class="col-lg-6">
																	<label>Mobil:</label>
																</div>
																<div class="col-lg-6">
																	<?php print htmlspecialchars($customer->contact_telephone_mobile); ?>
																</div>
															</div>
															<?php
														}
													?>
												</td>
												<td>
													<?php print count($customer->units); ?>
												</td>
												<td>
													<?php
														Bootstrap::link('Bearbeiten', $template->url('/admin/customer/' . $customer->id), array(
															'button'	=> 'primary'
														));
														
														Bootstrap::link('Löschen', $template->url('/admin/customer/' . $customer->id . '/delete'), array(
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