<?php
	namespace AF;
	
	class Core {
		private $router;
		private $template;
		
		public function __construct() {
			// Autoloading
			spl_autoload_register(array($this, 'load'));
			
			// Basic
			$this->template	= new Template($this);
			$this->router	= new Router($this);
			
			$this->init();
		}
		
		public function getTemplate() {
			return $this->template;
		}
		
		public function getRouter() {
			return $this->router;
		}
		
		public function load($class) {
			if(file_exists(PATH . DS . 'config.php')) {
				require_once(PATH . DS . 'config.php');
			}
		
			$file			= trim($class, '\\');	// Evntl. vorangegangenen Backslashes entfernen
			$file_array		= explode('\\', $file);
			array_shift($file_array);				// Root-Namespace entfernen
			array_unshift($file_array, 'classes');	// Root-Dir hinzufügen
			
			$file			= implode(DS, $file_array);
			$path			= PATH . DS . strtolower($file . '.class.php');

			if(file_exists($path)) {
				require_once($path);
			
			// It's a Lib?
			} else {
				$file			= trim($class, '\\');	// Evntl. vorangegangenen Backslashes entfernen
				$file_array		= explode('\\', $file);
				array_unshift($file_array, $file);		// Lib-Dir hinzufügen
				array_unshift($file_array, 'libs');		// Root-Dir hinzufügen
				
				$file			= implode(DS, $file_array);
				$path			= PATH . DS . strtolower($file . '.php');
				
				if(file_exists($path)) {
					require_once($path);
				}
			}
		}
		
		private function init() {
			require_once(PATH . DS . 'routes.php');
			
			// Execute
			$this->router->run();
		}
	}
?>