<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="woocommerce_booking_person wc-metabox closed">
	<h3>
		<button type="button" class="unlink_booking_person button" rel="<?php echo esc_attr( $person_type->get_id() ); ?>"><?php _e( 'Unlink', 'woocommerce-bookings' ); ?></button>
		<div class="handlediv" title="<?php _e( 'Click to toggle', 'woocommerce-bookings' ); ?>"></div>

		<strong>#<?php echo esc_html( $person_type->get_id() ); ?> &mdash; <span class="person_name"><?php echo esc_html( $person_type->get_name() ); ?></span></strong>

		<input type="hidden" name="person_id[<?php echo $loop; ?>]" value="<?php echo esc_attr( $person_type->get_id() ); ?>" />
		<input type="hidden" class="person_menu_order" name="person_menu_order[<?php echo $loop; ?>]" value="<?php echo $loop; ?>" />
	</h3>
	<table cellpadding="0" cellspacing="0" class="wc-metabox-content">
		<tbody>
			<tr>
				<td>
					<label><?php _e( 'Person Type Name', 'woocommerce-bookings' ); ?>:</label>
					<input type="text" class="person_name" name="person_name[<?php echo $loop; ?>]" value="<?php echo esc_attr( $person_type->get_name( 'edit' ) ); ?>" placeholder="<?php _e( 'Name', 'woocommerce-bookings' ) . $loop; ?>" />
				</td>
				<td>
					<label><?php _e( 'Base Cost', 'woocommerce-bookings' ); ?>:</label>
					<input type="number" name="person_cost[<?php echo $loop; ?>]" value="<?php echo esc_attr( $person_type->get_cost( 'edit' ) ); ?>" placeholder="0.00" step="0.01" />

					<?php do_action( 'woocommerce_bookings_after_person_cost', $person_type->get_id() ); ?>
				</td>
				<td>
					<label><?php _e( 'Block Cost', 'woocommerce-bookings' ); ?>:</label>
					<input type="number" name="person_block_cost[<?php echo $loop; ?>]" value="<?php echo esc_attr( $person_type->get_block_cost( 'edit' ) ); ?>" placeholder="0.00" step="0.01" />

					<?php do_action( 'woocommerce_bookings_after_person_block_cost', $person_type->get_id() ); ?>
				</td>

				<?php do_action( 'woocommerce_bookings_after_person_block_cost_column', $person_type->get_id() ); ?>
			</tr>
			<tr>
				<td>
					<label><?php _e( 'Description', 'woocommerce-bookings' ); ?>:</label>
					<input type="text" class="person_description" name="person_description[<?php echo $loop; ?>]" value="<?php echo esc_attr( $person_type->get_description( 'edit' ) ); ?>" />
				</td>
				<td>
					<label><?php _e( 'Min', 'woocommerce-bookings' ); ?>:</label>
					<input type="number" name="person_min[<?php echo $loop; ?>]" value="<?php echo esc_attr( $person_type->get_min( 'edit' ) ); ?>" min="0" />
				</td>
				<td>
					<label><?php _e( 'Max', 'woocommerce-bookings' ); ?>:</label>
					<input type="number" name="person_max[<?php echo $loop; ?>]" value="<?php echo esc_attr( $person_type->get_max( 'edit' ) ); ?>" min="0" />
				</td>

				<?php do_action( 'woocommerce_bookings_after_person_max_column', $person_type->get_id() ); ?>
			</tr>
			<!-- Customize add more some fields from Klook -->
			<tr>
				<td>
					<label>Klook Market Price:</label>
					<!-- exchange_rate_vnd * person_klook_market_price -->
					<?php //echo get_option('exchange_rate_vnd'); ?>
					<input type="number" name="person_klook_market_price[<?php echo $loop; ?>]" value="<?php echo esc_attr( $person_type->get_klook_market_price('edit' ) ); ?>" />
				</td>
				<td>
					<label>Klook Price:</label>
					<input type="number" name="person_klook_price[<?php echo $loop; ?>]" value="<?php echo esc_attr( $person_type->get_klook_price('edit' ) ); ?>" />
				</td>
				<td>
					<label>Klook Name:</label>
					<input type="text" name="person_klook_name[<?php echo $loop; ?>]" value="<?php echo esc_attr( $person_type->get_klook_name('edit' ) ); ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<label>Tiền lời:</label>
					<input type="number" name="person_profit[<?php echo $loop; ?>]" value="<?php echo esc_attr( $person_type->get_profit('edit' ) ); ?>" />
				</td>
			</tr>
			<!-- The End -->
		</tbody>
	</table>
</div>
