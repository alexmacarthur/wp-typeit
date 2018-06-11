<?php

namespace TypeIt;

class Utilities {

	public static function get_typed_options($options = array()) {

		//-- Weird way of ensuring each value matches the type of the defaults.
		$formattedOptions = array();

		foreach($options as $key => $value) {

			//-- Lowercase this because shortcode attributes MUST be lowercase.
			$key = strtolower($key);

			$default = Store::get('option_defaults')[$key];

			//-- Make sure the given key is set in case it needs capital letters for JS use.
			$givenKey = isset($default['js_key']) ? $default['js_key'] : $key;

			$type = gettype($default['default_value']);

			switch($type) {
				case 'string':
					$formattedOptions[$givenKey] = (string) $value;
					break;
				case 'integer':
					$formattedOptions[$givenKey] = (int) $value;
					break;
				case 'array':
					$formattedOptions[$givenKey] = (array) $value;
					break;
				case 'boolean': 

					if(gettype($value) === 'boolean') {
						$formattedOptions[$givenKey] = $value;
						break;
					}

					if(gettype($value) === 'string') {
						$formattedOptions[$givenKey] = in_array($value, array('true', 'on')) ? true : false;
					}

					break;
					
				default:
					if(is_numeric($value)) {
						$formattedOptions[$givenKey] = (int) $value;
					} else {
						$formattedOptions[$givenKey] = $value;
					}
			}
		}

		return $formattedOptions;
	}
}
