<?php
	namespace AF;
	use \AF\Database;
	
	class Template {
		private $core;
		private $assigns = array();
		
		public function __construct($core) {
			$this->core = $core;
			
			ob_start('ob_gzhandler');
		}
		
		public function assign($name, $value) {
			$this->assigns[$name] = $value;
		}
		
		public function display($file, $arguments = array()) {
			$template	= $this;
			
			foreach($arguments AS $name => $value) {
				${$name} = $value;
			}
			
			if(file_exists(PATH . DS . 'pages' . DS . $file . '.php')) {
				require_once(PATH . DS . 'pages' . DS . $file . '.php');
			}
			
			if(file_exists(PATH . DS . 'template' . DS . $file . '.php')) {
				foreach($this->assigns AS $name => $value) {
					${$name} = $value;
				}
				
				require_once(PATH . DS . 'template' . DS . $file . '.php');
			}
		}
		
		public function header() {
			$template = $this;
			
			foreach($this->assigns AS $name => $value) {
				${$name} = $value;
			}
			
			require_once(PATH . DS . 'template' . DS . 'header.php');
		}
		
		public function footer() {
			$template = $this;
			
			foreach($this->assigns AS $name => $value) {
				${$name} = $value;
			}
			
			require_once(PATH . DS . 'template' . DS . 'footer.php');
		}
		
		public function url($path) {
			// @ToDo calculate Domain
			return SITE_URL . $path;
		}
		
		public function getBadges($type) {
			switch($type) {
				case 'customers':
					printf('<span class="badge">%s</span>', Database::count('SELECT * FROM `af_customers`'));				
				break;
				case 'companys':
					printf('<span class="badge">%s</span>', Database::count('SELECT * FROM `af_companys`'));				
				break;
				case 'propertys':
					printf('<span class="badge badge-info">%s</span>', Database::count('SELECT * FROM `af_rental_units`'));
					printf('<span class="badge">%s</span>', Database::count('SELECT * FROM `af_rental_propertys`'));
				break;
				case 'contracts':
					printf('<span class="badge badge-danger">%s</span>', 0);
					printf('<span class="badge">%s</span>', 0);
					printf('<span class="badge badge-success">%s</span>', 0);
				break;
				case 'users':
					printf('<span class="badge">%s</span>', Database::count('SELECT * FROM `af_users`'));				
				break;
			}
		}
	}
?>