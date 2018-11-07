<?php
/**
 * The template used for number fields in the booking form, such as persons or durations.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce-bookings/booking-form/number.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/bookings-templates/
 * @author  Automattic
 * @version 1.8.0
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$after = isset( $field['after'] ) ? $field['after'] : null;
$class = $field['class'];
$label = $field['label'];
$total_cost = $field['totalcost'];
$max   = isset( $field['max'] ) ? $field['max'] : null;
$min   = isset( $field['min'] ) ? $field['min'] : null;
$name  = $field['name'];
$step  = isset( $field['step'] ) ? $field['step'] : null;
?>
<div class="form-field form-field-wide <?php echo implode( ' ', $class ); ?>">
<?php

if($total_cost > 0 && $name != ''){ ?>
    <div class="person_type">
            <div class="col small-4">
                <label for="<?php echo $name; ?>"><?php echo $label; ?><br><span><?php echo ( ! empty( $after ) ) ? $after : ''; ?></span></label>
            </div>
            <div class="col small-4 cprice">
                <?php echo number_format($total_cost); ?>
            </div>
            <div class="col small-4 cnum">
                <input
                    type="number"
                    value="<?php echo ( ! empty( $min ) ) ? $min : 0; ?>"
                    step="<?php echo ( isset( $step ) ) ? $step : ''; ?>"
                    min="<?php echo ( isset( $min ) ) ? $min : ''; ?>"
                    max="<?php echo ( isset( $max ) ) ? $max : ''; ?>"
                    name="<?php echo $name; ?>"
                    id="<?php echo $name; ?>"
                />
            </div>
            <div class="clearfix"></div>
    </div>
   
<?php }  
else {
?>
<div class="iput">
    <p class="form-field form-field-wide <?php echo implode( ' ', $class ); ?>">
    <label for="<?php echo $name; ?>"><?php echo $label; ?>:</label>
    <input
        type="number"
    	value="<?php echo ( ! empty( $min ) ) ? $min : 0; ?>"
		step="<?php echo ( isset( $step ) ) ? $step : ''; ?>"
		min="<?php echo ( isset( $min ) ) ? $min : ''; ?>"
		max="<?php echo ( isset( $max ) ) ? $max : ''; ?>"
		name="<?php echo $name; ?>"
		id="<?php echo $name; ?>"
		/> <?php echo ( ! empty( $after ) ) ? $after : ''; ?>
	</p>
</div>
<?php }  ?>
</div>


