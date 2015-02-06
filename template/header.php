<?php
	use \AF\Auth;
	use \AF\Request;
?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<title><?php print SITE_NAME; ?></title>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="robots" content="index, follow" />
		<meta name="generator" content="Adi Framework 1.0.0" />
		<link rel="shortcut icon" type="image/x-icon" href="<?php print $template->url('/images/favicon.ico'); ?>" />
		<link rel="search" type="application/opensearchdescription+xml" href="<?php print $template->url('/opensearch.xml'); ?>" title="<?php print SITE_NAME; ?>" />
		
		<!-- Stylesheets -->
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,300italic" />
		<link rel="stylesheet" type="text/css" href="<?php print $template->url('/css/bootstrap.css'); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php print $template->url('/css/bootstrap-switch.css'); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php print $template->url('/css/bootstrap-datetime.css'); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php print $template->url('/css/style.css'); ?>" />
		
		<!--[if lt IE 9]>
			<script type="text/javascript" src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script type="text/javascript">window.html5 || document.write('<script type="text/javascript" src="<?php print $template->url('/js/html5shiv.js'); ?>"><\/script>');</script>
			<script type="text/javascript" src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
			<script type="text/javascript">window.respond || document.write('<script type="text/javascript" src="<?php print $template->url('/js/respond.js'); ?>"><\/script>');</script>
		<![endif]-->
		<!--[if gte IE 9]>
			<meta name="application-name" content="<?php print SITE_NAME; ?>" />
			<meta name="msapplication-tooltip" content="<?php print SITE_NAME; ?> öffnen" />
			<meta name="msapplication-window" content="width=1600;height=1200" />
			<meta name="msapplication-starturl" content="<?php print SITE_URL; ?>" />
			<meta name="msapplication-navbutton-color" content="#202020" />
		<![endif]-->
	</head>
	<body class="<?php print (Auth::isLoggedIn() ? 'logged_in' : 'logged_out');?>">
		<input type="hidden" name="api_url" value="<?php print $template->url('/ajax'); ?>" />
		<div id="quickbox" style="display: none;">
			<div class="loading"></div>
		</div>
		<?php
			if(Auth::isLoggedIn()) {
				?>
				<nav id="sidebar">
					<ul class="sidebar-nav">
						<li class="sidebar-brand"><a href="<?php print $template->url('/'); ?>"><span><?php print SITE_NAME; ?></span></a></li>
						<li><a href="<?php print $template->url('/admin/contracts'); ?>">Aufträge <?php $template->getBadges('contracts'); ?></a></li>
						<li><a href="<?php print $template->url('/admin/customers'); ?>">Kunden / Mieter <?php $template->getBadges('customers'); ?></a></li>
						<li><a href="<?php print $template->url('/admin/companys'); ?>">Firmen <?php $template->getBadges('companys'); ?></a></li>
						<li><a href="<?php print $template->url('/admin/rental/propertys'); ?>">Mietobjekte <?php $template->getBadges('propertys'); ?></a></li>
						<li><a href="<?php print $template->url('/admin/users'); ?>">Benutzer <?php $template->getBadges('users'); ?></a></li>
						<li><a href="<?php print $template->url('/admin/logout'); ?>">Logout</a></li>
					</ul>
				</nav>
				<section id="content">
				<?php
			}
		?>