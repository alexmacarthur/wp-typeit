<?php

namespace TypeIt;

add_action('wp_enqueue_scripts', 'TypeIt\register_typeit_script');

function register_typeit_script() {
    wp_register_script(
    'typeit',
    'https://cdnjs.cloudflare.com/ajax/libs/typeit/' . Store::get('typeit_version') . '/typeit.min.js',
    array(),
    null,
    true );
}
