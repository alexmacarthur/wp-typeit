<?php

namespace TypeIt;

add_shortcode('typeit', '\TypeIt\register_shortcode');

function register_shortcode($atts, $content = '') {

    $args = shortcode_atts(
        Store::get('option_default_values'),
        $atts
    );
    
    $args = apply_filters('typeit:shortcode_atts', Utilities::get_typed_options($args));

    $id = 'typeit_' . mt_rand(100000, 999999);

    wp_enqueue_script('typeit');

    wp_add_inline_script('typeit', "window." . $id . " = new TypeIt('#" . $id . "', " . json_encode($args) . ");");

    return '<span id="' . $id . '">' . $content . '</span>';
}
