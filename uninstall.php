<?php
if(!defined('WP_UNINSTALL_PLUGIN') or !WP_UNINSTALL_PLUGIN) exit;
	
	delete_option('adsde_db_version');

	global $wpdb;
	$sde_table = $wpdb->prefix . 'adsde_dates';
	$wpdb->query("DROP TABLE $sde_table");
?>
