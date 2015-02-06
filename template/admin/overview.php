<?php
	use \AF\Bootstrap;
	
	$template->header();
	?>
	
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-6">
					<h3>Quick Navigation</h3>
					<div class="row big-buttons">
						<div class="col-lg-2">
							<a href="<?php print $template->url('/admin/contract/new'); ?>" class="glyphicon glyphicon-book"><span>Auftrag anlegen</span></a>
						</div>
						<div class="col-lg-2">
							<a href="<?php print $template->url('/admin/customer/new'); ?>" class="glyphicon glyphicon-user"><span>Kunde anlegen</span></a>
						</div>
						<div class="col-lg-2">
							<a href="<?php print $template->url('/admin/company/new'); ?>" class="glyphicon glyphicon-lock"><span>Firma anlegen</span></a>
						</div>
						<div class="col-lg-2">
							<a href="<?php print $template->url('/admin/rental/property/new'); ?>" class="glyphicon glyphicon-home"><span>Objekt anlegen</span></a>
						</div>
						<div class="col-lg-2">
							<a href="<?php print $template->url('/admin/user/new'); ?>" class="glyphicon glyphicon-star-empty"><span>Benutzer anlegen</span></a>
						</div>
						<div class="col-lg-2">
							<a href="<?php print $template->url('/admin/logout'); ?>" class="glyphicon glyphicon-off"><span>Abmelden</span></a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<h3>Suche</h3>
					<p>Hier können Sie suchen.</p>
					<form role="form" action="<?php print $template->url('/admin/search/'); ?>" method="get" autocomplete="off">
						<?php
							Bootstrap::input(NULL, array(
								'type'			=> 'text',
								'name'			=> 'q',
								'value'			=> '',
								'placeholder'	=> 'Suchwort...'
							));
						?>
					</form>
				</div>
			</div>
		</div>
	<?php
	$template->footer();
?>