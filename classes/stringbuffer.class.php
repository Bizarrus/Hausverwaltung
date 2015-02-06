<?php
	namespace AF;
	
	class StringBuffer {
		private $data = '';
		
		public function append() {
			$count	= func_num_args();
			$args	= func_get_args();
			
			if($count >= 2) {
				$format = $args[0];
				array_shift($args);
				$this->data .= vsprintf($format, $args);
			} else {
				$this->data .= $args[0];
			}
		}
		
		public function toString() {
			return $this->data;
		}
	}
?>