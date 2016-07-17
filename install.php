<?php
/** Build the tables and add options **/
global $adsde_db_version;
$adsde_db_version = '1.0.1';
add_option('adsde_db_version', $adsde_db_version);

	function create_adsde_tables() {
		
		global $wpdb;
		global $adsde_db_version;
		$sde_table = $wpdb->prefix . 'adsde_dates';
		
		if($wpdb->get_var("show tables like '$sde_table'") != $sde_table) {
			
			$sql = "CREATE TABLE " . $sde_table . " (
				sde_id mediumint(9) NOT NULL AUTO_INCREMENT,
				plan_id mediumint(9) NOT NULL,
				specific_date date DEFAULT '0000-00-00' NOT NULL,
				UNIQUE KEY id (sde_id)
			);";
		
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
			
		} else {
			
			$installed_ver = get_option( "adsde_db_version" );
			if($installed_ver != $adsde_db_version) {
				$sql = "CREATE TABLE " . $sde_table . " (
				sde_id mediumint(9) NOT NULL AUTO_INCREMENT,
				plan_id mediumint(9) NOT NULL,
				specific_date date DEFAULT '0000-00-00' NOT NULL,
				UNIQUE KEY id (sde_id)
			);";
		
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
			
			update_option( 'adsde_db_version', $adsde_db_version );
			}
			
		}
		
	}
	?>
