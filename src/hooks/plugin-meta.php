<?php

namespace TypeIt;

add_filter('plugin_row_meta', 'TypeIt\add_plugin_meta', 10, 4);
add_action('wp_head', 'TypeIt\insert_header_comment');

function add_plugin_meta($plugin_meta, $plugin_file, $plugin_data, $status)
{
    if (strpos($plugin_file, 'wp-typeit') === false) {
        return $plugin_meta;
    }

    $plugin_meta[] = '<a target="_blank" rel="noopener noreferrer" href="https://typeitjs.com">Visit the TypeIt Website</a>';
    return $plugin_meta;
}

function insert_header_comment()
{
    echo "
<!-- 
  This site uses TypeIt, the most versatile typewriter effect library on the planet. 
  
  https://typeitjs.com
  ______               ___ _   
  |_   _|  _ _ __  ___|_ _| |_ 
    | || || | '_ \/ -_)| ||  _|
    |_| \_, | .__/\___|___|\__|
        |__/|_|                
-->\n\n";
}
