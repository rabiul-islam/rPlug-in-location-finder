<?php
/**
 * @package Location Finder
 * @version 1.1.0
 */
/*
Plugin Name: Location Finder
Plugin URI: https://github.com/rabiul-islam
Description: This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in two words sung most famously by Louis Armstrong: Hello, Dolly. When activated you will randomly see a lyric from <cite>Hello, Dolly</cite> in the upper right of your admin screen on every page.
Author: Md Rabiul Islam
Version: 1.1.0
Author URI: https://github.com/rabiul-islam
*/
// if accessed directly
if (!defined('ABSPATH'))
    exit;

define( 'LOCATIONFINDERPATH', plugin_dir_path( __FILE__ ) );

/**
 * Auto load widget elements
 */
 

 /**
* The core plugin class that is used to define internationalization,
* admin-specific hooks, and public-facing site hooks.
*/

 


//require plugin_dir_path( __FILE__ ) . 'admin/class-nss-location-finder-admin.php';
//include( plugin_dir_path( __FILE__ ) . 'admin/inc/custom-post/nss-custom-post.php');
//include( plugin_dir_path( __FILE__ ) . 'admin/inc/custom-post/nss-taxonomics.php');

//public 
require plugin_dir_path( __FILE__ ) . 'public/class-nss-location-finder-public.php';