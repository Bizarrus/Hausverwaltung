<?php
	use \AF\Auth;
	use \AF\Response;
	use \AF\StringBuffer;
	use \AF\Template;
	
	$this->router->addRoute('/', function() {
		Response::redirect('/admin');
	});
	
	$this->router->addRoute('/admin', function() {
		Response::redirect('/admin/overview');
	});
	
	$this->router->addRoute('/opensearch.xml', function() {
		Response::addHeader('Content-Type', 'application/xml');
		Response::header();
		
		$output = new StringBuffer();
		$output->append('<?xml version="1.0" encoding="UTF-8"?>');
		$output->append('<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/" xmlns:moz="http://www.mozilla.org/2006/browser/search/">');
		$output->append(sprintf('<ShortName>%s</ShortName>', SITE_NAME));
		$output->append(sprintf('<Description>Site search for %s</Description>', SITE_NAME));
		$output->append('<InputEncoding>UTF-8</InputEncoding>');
		$output->append(sprintf('<Image width="16" height="16" type="image/x-icon">%s</Image>', Template::url('/images/favicon.ico')));
		$output->append(sprintf('<Url type="text/html" method="GET" template="%s/admin/search/"><Param name="q" value="{searchTerms}" /></Url>', SITE_URL));
		$output->append(sprintf('<moz:SearchForm>%s</moz:SearchForm>', SITE_URL));
		$output->append('</OpenSearchDescription>');
		print $output->toString();
	});
	
	$this->router->addRoute('/ajax', function() {
		$this->template->display('ajax');
	});
	
	$this->router->addRoute('/admin/search', function() {
		if(!Auth::isLoggedIn()) {
			Response::redirect('/admin/login');
		}
		
		$this->template->display('admin/search');
	});
	
	$this->router->addRoute('/admin/overview', function() {
		if(!Auth::isLoggedIn()) {
			Response::redirect('/admin/login');
		}
		
		$this->template->display('admin/overview');
	});
	
	// Admin :: Logout
	$this->router->addRoute('/admin/logout', function() {
		if(Auth::isLoggedIn()) {
			Auth::logout();
		}
		
		Response::redirect('/admin');
	});
	
	// Admin :: Login
	$this->router->addRoute('/admin/login', function() {
		if(Auth::isLoggedIn()) {
			Response::redirect('/admin');
		}
		
		$this->template->display('admin/login');
	});
	
	// Admin :: Users
	$this->router->addRoute('/admin/users', function() {
		if(!Auth::isLoggedIn()) {
			Response::redirect('/admin/login');
		}
		
		$this->template->display('admin/users');
	});
	
	// Admin :: User
	$this->router->addRoute('^/admin/user/([0-9]+|new)(?:/(delete))?$', function($id, $action = '') {
		if(!Auth::isLoggedIn()) {
			Response::redirect('/admin/login');
		}
		
		$this->template->display('admin/user', array(
			'id'		=> $id,
			'action'	=> $action
		));
	});
	
	// Admin :: Customers
	$this->router->addRoute('/admin/customers', function() {
		if(!Auth::isLoggedIn()) {
			Response::redirect('/admin/login');
		}
		
		$this->template->display('admin/customers');
	});
	
	// Admin :: Customer
	$this->router->addRoute('^/admin/customer/([0-9]+|new)(?:/(delete))?$', function($id, $action = '') {
		if(!Auth::isLoggedIn()) {
			Response::redirect('/admin/login');
		}
		
		$this->template->display('admin/customer', array(
			'id'		=> $id,
			'action'	=> $action
		));
	});
	
	// Admin :: Companys
	$this->router->addRoute('/admin/companys', function() {
		if(!Auth::isLoggedIn()) {
			Response::redirect('/admin/login');
		}
		
		$this->template->display('admin/companys');
	});
	
	// Admin :: Company
	$this->router->addRoute('^/admin/company/([0-9]+|new)(?:/(delete))?$', function($id, $action = '') {
		if(!Auth::isLoggedIn()) {
			Response::redirect('/admin/login');
		}
		
		$this->template->display('admin/company', array(
			'id'		=> $id,
			'action'	=> $action
		));
	});
	
	// Admin :: Rental Propertys
	$this->router->addRoute('/admin/rental/propertys', function() {
		if(!Auth::isLoggedIn()) {
			Response::redirect('/admin/login');
		}
		
		$this->template->display('admin/rental/propertys');
	});
	
	// Admin :: Rental Property
	$this->router->addRoute('^/admin/rental/property/([0-9]+|new)(?:/(delete))?$', function($id, $action = '') {
		if(!Auth::isLoggedIn()) {
			Response::redirect('/admin/login');
		}
		
		$this->template->display('admin/rental/property', array(
			'id'		=> $id,
			'action'	=> $action
		));
	});
	
	// Admin :: Contracts
	$this->router->addRoute('/admin/contracts', function() {
		if(!Auth::isLoggedIn()) {
			Response::redirect('/admin/login');
		}
		
		$this->template->display('admin/contracts');
	});
	
	// Admin :: Contracts
	$this->router->addRoute('^/admin/contract/([0-9]+|new)(?:/(delete))?$', function($id, $action = '') {
		if(!Auth::isLoggedIn()) {
			Response::redirect('/admin/login');
		}
		
		$this->template->display('admin/contract', array(
			'id'		=> $id,
			'action'	=> $action
		));
	});
	
	// Admin :: PDF
	$this->router->addRoute('/pdf', function() {
		$this->template->display('pdf');
	});
	
	// Default
	#$this->router->redirectTo('/');
?>