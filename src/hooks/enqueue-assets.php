<?php

namespace TypeIt;

add_action('wp_enqueue_scripts', 'TypeIt\register_typeit_script', 11);

function register_typeit_script()
{
    wp_register_script(
        'typeit',
        'https://unpkg.com/typeit@' . Store::get('typeit_version') . '/dist/index.umd.js',
        [],
        null,
        true
    );
}
