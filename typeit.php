<?php
/**
* Plugin Name: WP TypeIt
* Plugin URI: https://typeitjs.com
* Description: Easily create and manage typewriter effects using the JavaScript utility, TypeIt.
* Version: 1.0.1
* Author: Alex MacArthur
* Author URI: https://macarthur.me
* License: GPLv2 or later
* License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
namespace TypeIt;

if ( !defined( 'WPINC' ) ) {
  die;
}

if(!class_exists('\\TypeIt\\App')) {

  require_once(ABSPATH . 'wp-admin/includes/plugin.php');
  require_once(dirname(__FILE__) . '/vendor/autoload.php');

  class App {
    
    public static function go() {
      $GLOBALS[__CLASS__] = new self;
      return $GLOBALS[__CLASS__];
    }

    /**
     * Instatiate necessary classes, enqueue admin scripts.
     */
    public function __construct() {
      $realpath = realpath(dirname(__FILE__));

      require_once($realpath . '/src/hooks/shortcode.php');

      add_filter( 'plugin_row_meta', array($this, 'add_plugin_meta'), 10, 4);
      add_action( 'wp_enqueue_scripts', array($this, 'set_up_front_styles_and_scripts' ));
      add_action( 'wp_head', array($this, 'insert_header_comment'));
    }

    public function add_plugin_meta($plugin_meta, $plugin_file, $plugin_data, $status) {
      if(strpos($plugin_file, 'wp-typeit') === false) return $plugin_meta;
      $plugin_meta[] = '<a href="https://typeitjs.com">Visit the TypeIt Website</a>';
      return $plugin_meta;
    }

    /**
     * Spit out a nice logo in the site's header.
     *
     * @return void
     */
    public static function insert_header_comment() {
      echo "
<!-- 
  This site uses TypeIt, the most versatile animated typing utility on the planet. 
  
  https://typeitjs.com
  ______               ___ _   
  |_   _|  _ _ __  ___|_ _| |_ 
    | || || | '_ \/ -_)| ||  _|
    |_| \_, | .__/\___|___|\__|
        |__/|_|                
-->\n\n";
    }

    public function set_up_front_styles_and_scripts() {
      wp_register_script(
        'typeit',
        'https://cdnjs.cloudflare.com/ajax/libs/typeit/' . Store::get('typeit_version') . '/typeit.min.js',
        array(),
        null,
        true );
    }
  }

  App::go();
  
}