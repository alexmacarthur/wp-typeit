<?php
/**
* Plugin Name: WP TypeIt
* Description: Easily create and manage typewriter effects using the JavaScript utility, TypeIt.
* Version: 1.0.0
* Author: Alex MacArthur
* Author URI: https://macarthur.me
* License: GPLv2 or later
* License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
namespace TypeIt;

if ( !defined( 'WPINC' ) ) {
  die;
}

require_once(ABSPATH . 'wp-admin/includes/plugin.php');
require_once('vendor/autoload.php');

class App {

  private static $instance;
  protected $options_prefix = 'typeit';
  
  public static function generate_instance() {
    if(!isset($GLOBALS[static::class]) || is_null($GLOBALS[static::class])) {
			$GLOBALS[static::class] = new static();
    }
  }

  /**
   * Instatiate necessary classes, enqueue admin scripts.
   */
  public function __construct() {
    
    new Shortcode;

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
    _____               ___ _   
  |_   _|  _ _ __  ___|_ _| |_ 
    | || || | '_ \/ -_)| ||  _|
    |_| \_, | .__/\___|___|\__|
        |__/|_|                
-->\n\n";
  }

  /**
   * Delete global and post/page data.
   *
   * @return void
   */
  public static function delete_options_and_meta() {
    global $wpdb;
    delete_option(Store::get('options_prefix'));
    $wpdb->delete( $wpdb->prefix . 'postmeta', array( 'meta_key' => Store::get('options_prefix')) );
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
App::generate_instance();

//-- On uninstallation, delete plugin-related database stuffs.
register_uninstall_hook( __FILE__, array('\TypeIt\App', 'delete_options_and_meta') );