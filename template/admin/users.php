<?php
	use \AF\Bootstrap;
	
	$template->header();
	?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<h1>Benutzer <?php Bootstrap::link('Neuen Benutzer', $template->url('/admin/user/new'), array('button' => 'info')); ?></h1>
					<p>Hier können Sie alle Benutzer im System administrieren.</p>
					<?php
						Bootstrap::alerts(true);
					?>
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Benutzername</th>
								<th>Aktionen</th>
							</tr>
						</thead>
						<tbody>
							<?php
								if(empty($users)) {
									?>
									<tr>
										<td colspan="3">
											<p class="text-center"><em>Es existieren keine Benutzer</em></p>
										</td>
									</tr>
									<?php
								} else {
									foreach($users AS $user) {
										?>
											<tr>
												<td><?php print $user->id; ?></td>
												<td><?php print htmlspecialchars($user->firstname); ?> <?php print htmlspecialchars($user->lastname); ?></td>
												<td><?php print htmlspecialchars($user->username); ?><br /><em><?php print htmlspecialchars($user->email); ?></em></td>
												<td>
													<?php
														Bootstrap::link('Bearbeiten', $template->url('/admin/user/' . $user->id), array(
															'button'	=> 'primary'
														));
														
														Bootstrap::link('Löschen', $template->url('/admin/user/' . $user->id . '/delete'), array(
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