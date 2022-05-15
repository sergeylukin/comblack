<?php
/**
 * @package  CareeristPlugin
 */
/*
Plugin Name: Careerist Plugin
Plugin URI: https://sergeylukin.com/
Description: Jobs platform management software
Version: 1.0.0
Author: Sergey Lukin
Author URI: https://sergeylukin.com/
License: private
Text Domain: careerist-plugin
*/

// If this file is called firectly, abort!!!
defined( 'ABSPATH' ) or die( 'Hey, what are you doing here? You silly human!' );

// Require once the Composer Autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

/**
 * The code that runs during plugin activation
 */
function activate_careerist() {
	Inc\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'activate_careerist' );

/**
 * The code that runs during plugin deactivation
 */
function deactivate_careerist() {
	Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_careerist' );

/**
 * Initialize all the core classes of the plugin
 */
if ( class_exists( 'Inc\\Init' ) ) {
	Inc\Init::register_services();
}
