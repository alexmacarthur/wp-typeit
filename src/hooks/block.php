<?php

namespace TypeIt;

add_action('wp_enqueue_scripts', '\TypeIt\maybe_load_script_for_block', 11);
add_action('init', '\TypeIt\register_block_and_assets');

function register_block_and_assets()
{
    wp_register_script(
        'ti-block',
        WP_TYPEIT_PLUGIN_BASE_URL . '/build/index.js',
        ['wp-blocks', 'wp-element', 'wp-editor'],
        WP_TYPEIT_PLUGIN_VERSION
    );

    wp_register_style(
        'ti-block-editor-style',
        WP_TYPEIT_PLUGIN_BASE_URL . '/build/style-editor.css',
        ['wp-edit-blocks', 'wp-components'],
        WP_TYPEIT_PLUGIN_VERSION
    );

    register_block_type(Store::get('block_slug'), [
        'editor_script' => 'ti-block',
        'editor_style' => 'ti-block-editor-style',
        'style' => 'ti-block-frontend-style'
    ]);
}

function maybe_load_script_for_block()
{
    global $post;

    if(!isset($post->ID)) {
        return;
    }

    $hasBlock = has_block(Store::get('block_slug'), $post->ID); 
    $hasReusableBlock = Utilities::has_reusable_block(Store::get('block_slug'), $post);

    if ($hasBlock || $hasReusableBlock) {
        wp_enqueue_script('typeit');
    }
}
