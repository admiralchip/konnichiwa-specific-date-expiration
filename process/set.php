<?php
?>
	<div class="wrap">
	<h2><?php _e('Add / Edit Specific Expiration Date', 'adkonn_sde'); ?></h2>
	<?php
		if( !empty($_POST['set_specific_date']) ) {
			$plan_id = trim( $_POST['plan_id'] );
			$year = trim( $_POST['specific_year'] );
			$month = trim( $_POST['specific_mm'] );
			$day = trim( $_POST['specific_dd'] );
			
			if( empty($plan_id) ) {
				echo '<p class="adsde-error"><strong><em>' . __('Select a plan', 'adkonn_sde') . '</em></strong></p>';
			}
			
			if( empty($year) ) {
				echo '<p class="adsde-error"><strong><em>' . __('Select a year', 'adkonn_sde') . '</em></strong></p>';
			}
			
			if( empty($month) ) {
				echo '<p class="adsde-error"><strong><em>' . __('Select a month', 'adkonn_sde') . '</em></strong></p>';
			}
			
			if( empty($day) ) {
				echo '<p class="adsde-error"><strong><em>' . __('Select a day', 'adkonn_sde') . '</em></strong></p>';
			}
			
			if( !empty($plan_id) && !empty($year) && !empty($month) && !empty($day) ) {
				$specific_date = $year . '-' . $month . '-' . $day;
				
				global $wpdb;
				$sde_tbl = $wpdb->prefix . 'adsde_dates';
				
				if( empty($_GET['edit']) ) {
					
					$sde_exists = $wpdb->get_row( 
						$wpdb->prepare( 'SELECT sde_id FROM ' . $sde_tbl . ' WHERE plan_id = %d', $plan_id ) 
					);
					
					if(!$sde_exists) {
					$result = $wpdb->insert($sde_tbl,
						array(
							'plan_id' => $plan_id,
							'specific_date' => $specific_date
						),
						array(
							'%d',
							'%s'
						)
					);
					} else {
						$result = $wpdb->update($sde_tbl,
						array(
							'specific_date' => $specific_date
						),
						array( 
							'plan_id' => $plan_id 
						),
						array(
							'%s'
						),
						array(
							'%d'
						)
						);
					}
				} else {
					$result = $wpdb->update($sde_tbl,
					array(
						'specific_date' => $specific_date
					),
					array( 
						'plan_id' => $plan_id 
					),
					array(
						'%s'
					),
					array(
						'%d'
					)
					);
				}
				
				if($result) {
					echo '<p class="adsde-okay"><strong>' . __('Saved', 'adkonn_sde') . '</strong></p>';
				} else {
					echo '<p class="adsde-error"><strong>' . __('Changes not saved', 'adkonn_sde') . '</strong></p>';
				}
			}
			
		}
		global $wpdb;
		$plans_tbl = $wpdb->prefix . 'konnichiwa_plans';
		
		require(ADSDE_PATH.'/view/set.php');
	
	
?>
</div>
