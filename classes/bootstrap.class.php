<?php
	namespace AF;
	use \AF\StringBuffer;
	use \AF\Session;
	
	class Bootstrap {
		private static $valid_attributes = array('name', 'value', 'type', 'id', 'placeholder', 'class', 'rows', 'cols', 'target');
		
		private function when_attribute($array, $exclude = array()) {
			$html	= new StringBuffer();
			
			foreach($array AS $name => $value) {
				if(!in_array($name, Bootstrap::$valid_attributes) || in_array($name, $exclude)) {
					continue;
				}
				
				$html->append(sprintf(' %s="%s"', $name, $value));
			}
			
			return $html->toString();
		}
		
		private function when_array($array, $key) {
			if(isset($array[$key])) {
				return $array[$key];
			}
			
			return array();
		}
		
		public function link($title, $url, $arguments = array()) {
			$html				= new StringBuffer();
			
			if(!empty($arguments['button'])) {
				$arguments['classes'] = array_merge(array('btn', 'btn-'. $arguments['button']), Bootstrap::when_array($arguments, 'classes'));
			}
			
			$arguments['class']	= implode(' ', Bootstrap::when_array($arguments, 'classes'));
			
			if(isset($arguments['blank']) && $arguments['blank'] == true) {
				$arguments['target'] = '_bank';
			}
			
			if(isset($arguments['data'])) {
				foreach($arguments['data'] AS $name => $value) {
					Bootstrap::$valid_attributes[]	= 'data-' . $name;
					$arguments['data-' . $name]		= (is_array($value) ? str_replace('"', '\'', json_encode($value)) : $value);
				}
				
				unset($arguments['data']);
			}
			
			$html->append(sprintf('<a href="%2$s" %3$s>%1$s</a>', $title, $url, Bootstrap::when_attribute($arguments)));
			
			if(isset($arguments['return']) && $arguments['return'] == true) {
				return $html->toString();
			}
			
			print $html->toString();
		}
		
		public function staticText($title, $text) {
			$html				= new StringBuffer();
			
			if(!isset($arguments['container'])) {
				$arguments['container'] = true;
			}
			
			if($arguments['container'] != false) {
				$html->append('<div class="form-group">');
			}
			
			if(!empty($title)) {
				$html->append(sprintf('<label>%1$s</label>', $title));
			}
			
			$html->append('<div class="form-control">');
			$html->append($text);
			$html->append('</div>');
			
			if($arguments['container'] != false) {
				$html->append('</div>');
			}
			
			if(isset($arguments['return']) && $arguments['return'] == true) {
				return $html->toString();
			}
			
			print $html->toString();
		}
		
		public function input($title, $arguments) {
			$html				= new StringBuffer();
			$name				= $arguments['name'];
			$arguments['id']	= $name;
			
			if(!isset($arguments['container'])) {
				$arguments['container'] = true;
			}
			
			if($arguments['container'] != false) {
				$html->append('<div class="form-group">');
			}
			
			if(isset($arguments['data'])) {
				foreach($arguments['data'] AS $name => $value) {
					Bootstrap::$valid_attributes[]	= 'data-' . $name;
					$arguments['data-' . $name]		= (is_array($value) ? str_replace('"', '\'', json_encode($value)) : $value);
				}
				
				unset($arguments['data']);
			}
			
			if(!empty($title)) {
				$html->append(sprintf('<label for="%2$s">%1$s</label>', $title, $name));
			}
			
			if(isset($arguments['data-autocomplete'])) {
				$html->append(sprintf('<input class="form-control autocomplete" %s />', Bootstrap::when_attribute($arguments)));
				
				if(isset($arguments['data-reference'])) {
					$html->append('<input type="hidden" name="autocomplete_reference_%s" value="%s" />', $arguments['data-autocomplete'], $arguments['data-reference']);
				}
				
				$html->append('<div class="well autocomplete"></div>');
			} else {
				$html->append(sprintf('<input class="form-control" %s />', Bootstrap::when_attribute($arguments)));
			}
			
			if($arguments['container'] != false) {
				$html->append('</div>');
			}
			
			if(isset($arguments['return']) && $arguments['return'] == true) {
				return $html->toString();
			}
			
			print $html->toString();
		}
		
		public function button($title, $style, $arguments) {
			$html	= new StringBuffer();
			
			if(!isset($arguments['container'])) {
				$arguments['container'] = true;
			}
			
			if($arguments['container'] != false) {
				$html->append(sprintf('<div class="%s">', implode(' ', array_merge(array('form-group'), Bootstrap::when_array($arguments, 'container_classes')))));
			}
			
			if(isset($arguments['data'])) {
				foreach($arguments['data'] AS $name => $value) {
					Bootstrap::$valid_attributes[]	= 'data-' . $name;
					$arguments['data-' . $name]		= $value;
				}
				
				unset($arguments['data']);
			}
			
			$html->append(sprintf('<button%3$s class="%2$s">%1$s</button>', $title, implode(' ', array_merge(array('btn', 'btn-' . $style), Bootstrap::when_array($arguments, 'classes'))), Bootstrap::when_attribute($arguments)));
			
			if($arguments['container'] != false) {
				$html->append('</div>');
			}
			
			if(isset($arguments['return']) && $arguments['return'] == true) {
				return $html->toString();
			}
			
			print $html->toString();
		}
		
		public function textarea($title, $arguments) {
			$html				= new StringBuffer();
			$name				= $arguments['name'];
			$arguments['id']	= $name;
			
			if(!isset($arguments['container'])) {
				$arguments['container'] = true;
			}
			
			if($arguments['container'] != false) {
				$html->append('<div class="form-group">');
			}
			
			if(!empty($title)) {
				$html->append(sprintf('<label for="%2$s">%1$s</label>', $title, $name));
			}
			
			$arguments['classes']	= array_merge(array('form-control'), Bootstrap::when_array($arguments, 'classes'));
			$arguments['class']		= implode(' ', Bootstrap::when_array($arguments, 'classes'));
			
			$html->append(sprintf('<textarea %s>%s</textarea>', Bootstrap::when_attribute($arguments, array('value', 'type')), $arguments['value']));
			
			if($arguments['container'] != false) {
				$html->append('</div>');
			}
			
			if(isset($arguments['return']) && $arguments['return'] == true) {
				return $html->toString();
			}
			
			print $html->toString();
		}
		
		public function select($title, $arguments) {
			$html				= new StringBuffer();
			$name				= $arguments['name'];
			$arguments['id']	= $name;
			
			if(!isset($arguments['container'])) {
				$arguments['container'] = true;
			}
			
			if($arguments['container'] != false) {
				$html->append('<div class="form-group">');
			}
			
			if(!empty($title)) {
				$html->append(sprintf('<label for="%2$s">%1$s</label>', $title, $name));
			}
			
			$options = new StringBuffer();
			if(isset($arguments['values']) && count($arguments['values']) > 0) {
				foreach($arguments['values'] AS $index => $option) {
					$selected = (isset($arguments['value']) && $arguments['value'] == $option->{'value'} ? ' selected="selected"' : '');
					$disabled = (isset($option->{'enabled'}) && $option->{'enabled'} == false ? ' disabled="disabled"' : '');
					$options->append(sprintf('<option value="%s"%s%s>', $option->{'value'}, $selected, $disabled));
					$options->append($option->{'name'});
					$options->append('</option>');
				}
			}
			// $arguments['values']
			
			$html->append(sprintf('<select class="form-control" %s>%s</select>', Bootstrap::when_attribute($arguments, array('value', 'type')), $options->toString()));
			
			if($arguments['container'] != false) {
				$html->append('</div>');
			}
			
			if(isset($arguments['return']) && $arguments['return'] == true) {
				return $html->toString();
			}
			
			print $html->toString();
		}
		
		public function label($title) {
			$html	= new StringBuffer();
			
			$html->append('<label>');
			$html->append($title);
			$html->append('</label>');
			
			print $html->toString();
		}
		
		public function getSettings() {
			$bootstrap = (object) Session::get('bootstrap');
			
			if(!isset($bootstrap->alerts)) {
				$bootstrap->alerts = array();
			}
			
			return $bootstrap;
		}
		
		public function setSettings($bootstrap) {
			Session::set('bootstrap', $bootstrap);
		}
		
		public function alert($type, $message) {
			$bootstrap				= Bootstrap::getSettings();
			$bootstrap->alerts[]	= array(
				'type'		=> $type,
				'message'	=> $message
			);
			
			Bootstrap::setSettings($bootstrap);
		}
		
		public function alerts($delete_after_output = false) {
			$bootstrap				= Bootstrap::getSettings();
			$html					= new StringBuffer();
			
			foreach($bootstrap->alerts AS $index => $alert) {
				$html->append(sprintf('<p class="bg-%s">%s</p>', $alert['type'], $alert['message']));
				
				if($delete_after_output == true) {
					unset($bootstrap->alerts[$index]);
				}
			}
			
			if($delete_after_output == true) {
				Bootstrap::setSettings($bootstrap);
			}
			
			if(isset($arguments['return']) && $arguments['return'] == true) {
				return $html->toString();
			}
			
			print $html->toString();
		}
		
		public function datetime($title, $arguments) {
			$html				= new StringBuffer();
			
			if(!isset($arguments['container'])) {
				$arguments['container'] = true;
			}
			
			if($arguments['container'] != false) {
				$html->append(sprintf('<div class="%s">', implode(' ', array_merge(array('form-group'), Bootstrap::when_array($arguments, 'container_classes')))));
			}
			
			if(!empty($title)) {
				$html->append(sprintf('<label>%1$s</label>', $title));
			}
			
			$html->append('<div class="input-group date form_datetime" data-format="%s" data-clear="%s">', $arguments['format'], $arguments['clear'] ? 'true' : 'false');
			$html->append('<input type="text" class="form-control" name="%s" value="%s" />', $arguments['name'], $arguments['value']);
			$html->append('<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>');
			$html->append('</div>');
  
			if($arguments['container'] != false) {
				$html->append('</div>');
			}
			
			if(isset($arguments['return']) && $arguments['return'] == true) {
				return $html->toString();
			}
			
			print $html->toString();
		}
		
		public function toggle($title, $arguments) {
			$html				= new StringBuffer();
			
			if(!isset($arguments['container'])) {
				$arguments['container'] = true;
			}
			
			if($arguments['container'] != false) {
				$html->append(sprintf('<div class="%s">', implode(' ', array_merge(array('form-group'), Bootstrap::when_array($arguments, 'container_classes')))));
			}
			
			if(!empty($title)) {
				$html->append(sprintf('<label>%1$s</label>', $title));
			}
			
			$html->append('<input type="checkbox" class="form-control switch" name="%s" value="%s"%s />', $arguments['name'], isset($arguments['value']) ? $arguments['value'] : ($arguments['enabled'] ? 'true' : 'false'), $arguments['enabled'] ? ' checked="checked"' : '');
			
			if($arguments['container'] != false) {
				$html->append('</div>');
			}
			
			if(isset($arguments['return']) && $arguments['return'] == true) {
				return $html->toString();
			}
			
			print $html->toString();
		}
	}
?>