<?php
/**
* Plugin Name: WP TypeIt
* Plugin URI: https://typeitjs.com
* Description: Easily create and manage typewriter effects using the JavaScript utility, TypeIt.
* Version: 3.0.1
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

  $pluginData = get_plugin_data(__FILE__);

  define('WP_TYPEIT_PLUGIN_VERSION', $pluginData['Version']);

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

      require_once($realpath . '/src/hooks/block.php');
      require_once($realpath . '/src/hooks/update.php');
      require_once($realpath . '/src/hooks/shortcode.php');
      require_once($realpath . '/src/hooks/plugin-meta.php');
      require_once($realpath . '/src/hooks/enqueue-assets.php');
    }
    
  }

  App::go();
  
}
