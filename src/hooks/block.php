<?php

namespace TypeIt;

add_action('wp_enqueue_scripts', '\TypeIt\maybe_load_script_for_block', 11);
add_action('init', '\TypeIt\register_block_and_assets');

function register_block_and_assets()
{
    $pluginPath = realpath(__DIR__ . '/../..');
    $pluginUrl = plugins_url('wp-typeit');

    wp_register_script(
        'ti-block',
        $pluginUrl . '/build/index.js',
        ['wp-blocks', 'wp-element', 'wp-editor'],
        filemtime($pluginPath . '/build/index.js')
    );

    wp_register_style(
        'ti-block-editor-style',
        $pluginUrl . '/build/style-editor.css',
        ['wp-edit-blocks', 'wp-components'],
        filemtime($pluginPath . '/build/style-editor.css')
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
