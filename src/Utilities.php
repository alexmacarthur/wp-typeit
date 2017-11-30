<?php

namespace TypeIt;

class Utilities extends App {

	public static function get_typed_options($options = null) {

		//-- Weird way of ensuring each value matches the type of the defaults.
		$formattedOptions = array();

    foreach($options as $key => $value) {

			$type = gettype(Store::get('option_defaults')[$key]['default_value']);

      if($type === 'string') {
        $formattedOptions[$key] = (string) $value;
      }

      if($type === 'integer') {
        $formattedOptions[$key] = (int) $value;
      }

      if($type === 'boolean') {
				if(gettype($value) === 'boolean') {
					$formattedOptions[$key] = $value;
					continue;
				}

				if(gettype($value) === 'string') {
					$formattedOptions[$key] = in_array($value, array('true', 'on')) ? true : false;
				}
      }
    }

		return $formattedOptions;
	}
}
