<?php
// Function to update dates
	function adsde_update_dates() {
		
		global $wpdb;
		$subs_tbl = $wpdb->prefix . 'konnichiwa_subscriptions';
		$sde_tbl = $wpdb->prefix . 'adsde_dates';
		
		$sde_results = $wpdb->get_results( 'SELECT COUNT(sde_id) FROM ' . $sde_tbl );
		
		if($sde_results) {
			$results = $wpdb->get_results( 
				"SELECT $subs_tbl.plan_id AS sb_planid, $subs_tbl.expires AS expires, $sde_tbl.plan_id AS sd_planid, $sde_tbl.specific_date AS specific_date FROM $subs_tbl, $sde_tbl WHERE $subs_tbl.expires > CURDATE() AND ($subs_tbl.expires != $sde_tbl.specific_date) AND ($subs_tbl.plan_id = $sde_tbl.plan_id)" 
			);
				
			if($results) {
				foreach( $results as $res ) {
					$update_query = $wpdb->prepare( 'UPDATE ' . $subs_tbl . ' SET expires = %s WHERE expires > CURDATE() AND (expires != %s) AND (plan_id = %d)', $res->specific_date, $res->specific_date, $res->sd_planid );
					$update_res = $wpdb->query( $update_query ); 
				}
			}
		}
		
	}
	
	add_action('init', 'adsde_update_dates');

// Function to handle expired subscriptions

/**
 * Notes:
 *
 * There is a bug in Konnichiwa! that tells a user who has an active subscription
 * that their subscription is expired. This is happens if the user had a previous subscription
 * that expired and they subsequently renewed their subscription. 
 *
 * The purpose of this function is to change the status of expired subscriptions from active (1) to cancelled (2).
 * It can also be adapted to delete expired subscriptions to clear the database.
 */
 
 function adsde_handle_expired_subs() {
	 global $wpdb;
	 $subs_tbl = $wpdb->prefix . 'konnichiwa_subscriptions';
	 
	 $subs_results = $wpdb->get_results( 'SELECT COUNT(id) FROM ' . $subs_tbl . ' WHERE expires <= CURDATE()' );
	 if($subs_results) {
		 //Update query. To delete subs, comment below
		 //$query = $wpdb->prepare( 'UPDATE ' . $subs_tbl . ' SET status = %d WHERE expires <= CURDATE()', 2 );
		 //For delete query, comment the above and uncomment code below:
		 $query = "DELETE FROM $subs_tbl WHERE expires <= CURDATE()";
		 $wpdb->query($query);
	 }
 } 
 
 add_action('init', 'adsde_handle_expired_subs');
?>
