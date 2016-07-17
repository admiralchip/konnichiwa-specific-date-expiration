	
	<form method="POST" action="">
		<div class="adsde-wrap">
		<p><label for="plan_id"><strong><?php _e('Plan: ', 'adkonn_sde');?></strong></label>
		<?php
			if( empty($_GET['edit']) ) {
		?>
		<select name="plan_id">
			<option value=""><?php _e('Select a plan', 'adkonn_sde'); ?></option>
			<?php
				$plan_results = $wpdb->get_results( 'SELECT id, name FROM ' . $plans_tbl );
				
				if( $plan_results ) {
					foreach( $plan_results as $plans ) {
						?>
						<option value="<?php echo esc_attr($plans->id); ?>"><?php echo esc_html($plans->name); ?></option>
						<?php
					}
				}
			?>
		</select>
		<?php
			} else {
				$sde_id = filter_input( INPUT_GET, 'edit' );
				$sde_tbl = $wpdb->prefix . 'adsde_dates';
				$sde_results = $wpdb->get_row( 
					$wpdb->prepare('SELECT plan_id FROM ' . $sde_tbl . ' WHERE sde_id = %d', $sde_id)
					);
				if($sde_results) {
					$plan_id = $sde_results->plan_id;
				}
				$plan_results = $wpdb->get_row( 
					$wpdb->prepare('SELECT name FROM ' . $plans_tbl . ' WHERE id = %d', $plan_id)
					);
				?>
				<input type="hidden" name="plan_id" value="<?php echo esc_attr($plan_id); ?>">
				<strong><?php echo esc_html($plan_results->name); ?></strong>
				<?php
			}
		?>
		</p>
		<p>
			<label for="specific_date"><strong><?php _e('Set the date (YYYY-MM-DD): ', 'adkonn_sde'); ?></strong></label>
			<select name="specific_year">
				<option value=""><?php _e('Year', 'adkonn_sde'); ?></option>
				<?php
					$i = 2016;
					for($i; $i <= 2022; $i++) {
						echo '<option value="' . sprintf( '%04d', $i ) . '">' . sprintf( '%04d', $i ) . '</option>';
					}
				?>
			</select>
			<select name="specific_mm">
				<option value=""><?php _e('Month', 'adkonn_sde'); ?></option>
				<?php
					$i = 1;
					for($i; $i <= 12; $i++) {
						echo '<option value="' . sprintf( '%02d', $i ) . '">' . sprintf( '%02d', $i ) . '</option>';
					}
				?>
			</select>
			<select name="specific_dd">
				<option value=""><?php _e('Day', 'adkonn_sde'); ?></option>
				<?php
					$i = 1;
					for($i; $i <= 31; $i++) {
						echo '<option value="' . sprintf( '%02d', $i ) . '">' . sprintf( '%02d', $i ) . '</option>';
					}
				?>
			</select>
		</p>
		<p>
			<input type="submit" name="set_specific_date" value="<?php _e('Save', 'adkonn_sde'); ?>" />
		</p>
		</div>
	</form>
	
