<?php

namespace TypeIt;

class Shortcode extends App {

  public function __construct () {
    add_shortcode( 'typeit', array($this, 'register_shortcode') );
  }

  public function register_shortcode( $atts, $content = '' ) {

		$args = shortcode_atts(
			Store::get('option_default_values'),
			$atts
		);

		$args = apply_filters('typeit:shortcode_atts', Utilities::get_typed_options($args));

    //-- Generate random ID;
    $id = 'typeit_' . mt_rand(100000, 999999);

		wp_enqueue_script( 'typeit');

    wp_add_inline_script( 'typeit', "window." . $id . " = new TypeIt('#" . $id . "', " . json_encode($args) . ");");

    return '<span id="' . $id . '">' . $content . '</span>';
  }

}
