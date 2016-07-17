<?php
// Contents of the settings page

function ad_konn_sde() {
	
	$sde_page = admin_url('admin.php?page=adkonn-specific-date');
	
	if( empty($_GET['set']) ) {
	
	global $wpdb;
	$plans_tbl = $wpdb->prefix . 'konnichiwa_plans';
	$sde_tbl = $wpdb->prefix . 'adsde_dates';
	
	
	
	?>
	<div class="wrap">
	<?php
		echo '<h2>' . __('Konnichiwa! Specific Date Expiration', 'adkonn_sde').'</h2>';
		
		if( !empty($_GET['delete']) ) {
			$sde_id = filter_input(INPUT_GET, 'delete');
			
			global $wpdb;
			$sde_tbl = $wpdb->prefix . 'adsde_dates';
			
			$sde_exist = $wpdb->get_row( $wpdb->prepare( 'SELECT sde_id FROM ' . $sde_tbl . ' WHERE sde_id = %d', $sde_id ) );
			
			echo '<div class="adsde-wrap">';
			if($sde_exist) {
				if( isset($_POST['confirm_del']) ) {
					$del_query = $wpdb->prepare( 'DELETE FROM ' . $sde_tbl . ' WHERE sde_id = %d', $sde_id );
					$res = $wpdb->query($del_query);
			
					if($res) {
						echo '<p><strong><em>' . __('Record deleted', 'adkonn_sde') . '</em></strong></p>';
					}
				} elseif( isset($_POST['no_del']) ) {
					wp_redirect($sde_page);
				} else {
					echo '<p>' . __('Are you sure you want to delete record?', 'adkonn_sde') . '</p>';
				?>
				<form method="POST" action="">
					<input type="submit" name="confirm_del" value="<?php _e('Yes', 'adkonn_sde'); ?>">
					<input type="submit" name="no_del" value="<?php _e('No', 'adkonn_sde'); ?>">
				</form>
				<?php
				}
			} else {
				echo '<p class="adsde-error"><strong><em>' . __('Record doesn\'t exist', 'adkonn_sde') . '</em></strong></p>';
			}
			echo '</div>';
		}
	?>
		<p>
			<a href="<?php echo esc_url( add_query_arg('set', 'add', $sde_page) ); ?>">
				<?php _e( 'Add specific expiration date', 'adkonn_sde' ); ?>
			</a>
		</p>
		<table class="widefat">
			<tr>
				<th><?php _e('Plan name', 'adkonn_sde'); ?></th>
				<th><?php _e('Specific Expiration Date', 'adkonn_sde'); ?></th>
				<th><?php _e('Action', 'adkonn_sde')?></th>
			</tr>
			<?php 
				$plans_results = $wpdb->get_results(
					$wpdb->prepare( 
						"SELECT $plans_tbl.id, $plans_tbl.name, $sde_tbl.plan_id, $sde_tbl.sde_id, $sde_tbl.specific_date FROM $plans_tbl, $sde_tbl WHERE %d = %d", $plans_tbl.'.id', $sde_tbl.'.plan_id'
					)
				);
				if( $plans_results ) {
					foreach( $plans_results as $results ) {
						$class = ("alternate" == @$class) ? '' : 'alternate';
					?>
						<tr class="<?php echo $class?>">
							<td><?php echo $results->name; ?></td>
							<td><?php echo $results->specific_date; ?></td>
							<td>
								<a href="<?php echo esc_url( add_query_arg( array('set' => 'add', 'edit' => $results->sde_id), $sde_page ) ); ?>"><?php _e('Edit', 'adkonn_sde') ?></a> | 
								<a href="<?php echo esc_url( add_query_arg( 'delete', $results->sde_id, $sde_page ) ); ?>"><?php _e('Delete', 'adkonn_sde') ?></a>
							</td>
						</tr>
					<?php
					}
				} else {
					?>
					<tr>
						<td><strong><em><?php _e('Empty', 'adkonn_sde'); ?></em></strong></td>
					</tr>
					<?php
				}
			?>
		</table>
	</div>
	<?php
	} elseif ( !empty($_GET['set']) && (filter_input(INPUT_GET, 'set') == 'add') ) {
		require(ADSDE_PATH.'/process/set.php');
	}
}
?>
