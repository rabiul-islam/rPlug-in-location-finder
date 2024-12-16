<?php
/**
 * @package Location Finder
 * @version 1.1.0
 */
/*
Plugin Name: Location Finder
Plugin URI: #
Description: This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in two words sung most famously by Louis Armstrong: Hello, Dolly. When activated you will randomly see a lyric from <cite>Hello, Dolly</cite> in the upper right of your admin screen on every page.
Author: Md Islam
Version: 1.1.0
Author URI: http://ma.tt/
*/
// if accessed directly
if (!defined('ABSPATH'))
    exit;

 

/**
 * Auto load widget elements
 */
class Nss_Locator_Finder_Admin_AutoLoader {
    public static $instance = null;
    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function init() {
        add_action('admin_menu', array($this, 'nss_location_finder_menu'));    
        //add_action('init', array($this, 'location_finder_inc_file'));
    }
    public function locator_finder_shortcode() {
        
        
    }

    public function nss_location_finder_menu(){    
         add_menu_page( 'Location Finder Manager','Location Finder Manager','nss-location-finder-menu', 'nss-location-finder-menu', '');
        add_submenu_page('nss-location-finder-menu', "Settings", "Settings", 8, 'nss-location-finder-settings', array($this, 'nss_location_settings_page'));
        add_submenu_page('nss-location-finder-menu', "Add Custom Post Types", "Add Custom Post Types", 8, 'nss-add-post-types', array($this, 'nss_add_post_types_page'));    
    // 3=name, 6=slug 
    } 

    public function nss_location_settings_page(){ 
        include_once(plugin_dir_path( __FILE__ ). 'partials/location-finder-admin-display.php');
    }  
     public function nss_add_post_types_page(){ 
        include_once(plugin_dir_path( __FILE__ ). 'partials/nss-add-post-types.php');
    }   
    /**
     * @since 1.0
     */
   /* public function location_finder_inc_file() { 
      include( plugin_dir_path( __FILE__ ) . 'inc/functions/functions.php');
    }*/
}
Nss_Locator_Finder_Admin_AutoLoader::instance()->init();