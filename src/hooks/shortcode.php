<?php

namespace TypeIt;

add_shortcode('typeit', '\TypeIt\register_shortcode');
add_filter('typeit:shortcode_atts', '\TypeIt\convert_to_string');

function register_shortcode($atts, $content = '')
{
    $args = shortcode_atts(
        array_merge(Store::get('option_default_values'), ["element" => "span"]),
        $atts
    );

    $args = apply_filters('typeit:shortcode_atts', array_merge(Utilities::get_typed_options($args), ["element" => $args["element"]]));

    $id = 'typeit_' . mt_rand(100000, 999999);

    wp_enqueue_script('typeit');

    // Allow people to pass real JavaScript for a more finely-tuned animation.
    $manualQueue = empty($atts['queue']) ? "" :  "." . ltrim($atts['queue'], '.');

    wp_add_inline_script('typeit', "window.$id = new TypeIt('#$id', " . json_encode($args) . ")$manualQueue.go();");

    return '<' . $args["element"] . ' id="' . $id . '">' . $content . '</' . $args["element"] . '>';
}

function convert_to_string($args)
{
    //-- Ensure that for the free version, just a single simple string is passed.
    $args["strings"] = $args["strings"][0];

    //-- Make sure break tags don't have closing slash.
    $args["strings"] = str_replace("<br />", "<br>", $args["strings"]);

    return $args;
}
