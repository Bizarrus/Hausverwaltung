<?php
		use \AF\Auth;
		use \AF\Request;
		
			if(Auth::isLoggedIn()) {
				?>
					</section>
				<?php
			}
		?>
		<div class="alert modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title alert-title">Information</h4>
					</div>
					<div class="modal-body">
						<p class="alert-content"></p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="<?php print $template->url('/js/jquery.js'); ?>"><\/script>');</script>
		<script type="text/javascript" src="<?php print $template->url('/js/moment.js'); ?>"></script>
		<script type="text/javascript" src="<?php print $template->url('/js/bootstrap.js'); ?>"></script>
		<script type="text/javascript" src="<?php print $template->url('/js/bootstrap-switch.js'); ?>"></script>
		<script type="text/javascript" src="<?php print $template->url('/js/bootstrap-datetime.js'); ?>"></script>
		<script type="text/javascript" src="<?php print $template->url('/js/main.js'); ?>"></script>
	</body>
</html>