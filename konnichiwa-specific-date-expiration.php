<?php
/*
Plugin Name: Konnichiwa! Specific Date Expiration
Description: This plugin makes it possible for subscriptions to expire on a specific admin-defined date.
Version: 1.0
Author: admiralchip
Author URI: http://github.com/admiralchip
*/

defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

define( 'ADSDE_PATH', dirname( __FILE__ ) );

require_once( ADSDE_PATH.'/install.php' );
require_once( ADSDE_PATH.'/view/settings.php');
require_once( ADSDE_PATH.'/process/update-dates.php' );

register_activation_hook( __FILE__, 'create_adsde_tables' );

// Add menu item

function adsde_specific_date() {
	add_options_page('Konnichiwa! SDE', 'Konnichiwa! SDE', 'manage_options', 'adkonn-specific-date', 'ad_konn_sde');
}

add_action('admin_menu', 'adsde_specific_date');

// CSS

function adsde_load_css() {
	wp_register_style('adsde_styles', plugins_url('css/styles.css', __FILE__));
	wp_enqueue_style('adsde_genme_styles', plugins_url('css/styles.css', __FILE__)); 
}

add_action( 'admin_enqueue_scripts', 'adsde_load_css');
?>
