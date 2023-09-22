<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
?>

<?php if ( $product->get_ID() == ID_1FORYOU ) { ?>
<div class="woocommerce-variation-add-to-cart variations_button">
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	<?php
	do_action( 'woocommerce_before_add_to_cart_quantity' );

	woocommerce_quantity_input(
		array(
			'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
			'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
			'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
		)
	);

	do_action( 'woocommerce_after_add_to_cart_quantity' );
	?>

	<p class="important_info"><a href="">Payment Tips</a></p>

	<button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>

<script>
	//jQuery('.variations').hide();

	window.setTimeout(function () {
	    jQuery('.nyp label').text('Enter amount (R50.00 – R2500.00)');
	    jQuery('.minimum-price').hide();
	}, 1000);

	window.setTimeout(function () {
	    jQuery('.nyp label').text('Enter amount (R50.00 – R2500.00)');
	    jQuery('.minimum-price').hide();
	}, 5000);

</script>


<?php } else if ( $product->get_ID() == ID_ELECTRIC ) { ?>
<div class="woocommerce-variation-add-to-cart variations_button">
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	<?php
	do_action( 'woocommerce_before_add_to_cart_quantity' );

	woocommerce_quantity_input(
		array(
			'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
			'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
			'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
		)
	);

	do_action( 'woocommerce_after_add_to_cart_quantity' );
	?>

	<button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />

</div>
<style>
	.nyp {
		display: none !important;
	}
	.check_no {
		background: #fff;
		border: 1px solid #ff5f00;
		border-radius: 7px;
		cursor: pointer;
		float: right;
		font-family: 'Circular Std Book';
		font-size: 11px !important;
		font-weight: 700;
		margin-top: 15px;
		padding: 7px 15px;
		text-transform: uppercase;
	}
</style>
<script>

	jQuery('.variations').hide();

	jQuery('.field_meter_number').append('<button class="check_no">Check meter number <img src="<?php echo get_option('home'); ?>/wp-content/themes/onevoucher/images/loading.gif"></button>');
	jQuery('.field_how_pin').hide();
	jQuery('.single_add_to_cart_button').hide();
	jQuery('.check_no img').hide();
	jQuery('.field_amount').hide();

	// make sure amount has a decimal
	jQuery('.field_amount input').on('focusout', function() {
		var amount = jQuery(this).val();
		var amount = (Math.round(amount * 100) / 100).toFixed(2)
		if ( isNaN(amount) ) {
			var newamount = '0.00';
		} else {
			var newamount = amount;
		}
		jQuery(this).val(newamount);
		jQuery('.nyp input').val(newamount);
	});


	jQuery(function() {

		// show/hide amount field based on fbe selection
		jQuery('.field_fbe_only select').on('selectric-change', function() {

			var selval = jQuery('.field_fbe_only select option:selected').text();
			if (selval == 'No ') {
				jQuery('.field_amount').show();
			} else {
				jQuery('.field_amount').hide();
				jQuery('.nyp input').val('0.00');
				jQuery('.field_amount input').val('0.00');
			}
		});

	});

	// check meter number
	jQuery('.check_no').on( 'click', function(e) {
		e.preventDefault();

		// clear validation
		jQuery('.field_meter_number .frm_error').remove();
		jQuery('.field_amount .frm_error').remove();
		jQuery('.field_amount .frm_message').remove();
		jQuery('.check_no .frm_error').remove();

		// collect values
		var errors = 0;
		var field_meter_number = jQuery('.field_meter_number input').val();
		var field_meter_number_length = field_meter_number.length;
		var field_amount = jQuery('.nyp input').val();


		// validation
		var regExp = /[a-zA-Z]/g;
		if ( field_meter_number_length < 9 || field_meter_number_length > 13 || regExp.test(field_meter_number) ) {
			jQuery('.field_meter_number').append('<span class="frm_error">Please enter a valid meter number.</span>');
			errors = 1;
		}

		var selval = jQuery('.field_fbe_only select option:selected').text();
		if (selval == 'No ') {

			if ( field_amount < 10 || field_amount > 3500 || regExp.test(field_amount) ) {
				jQuery('.field_amount').append('<span class="frm_error">Please enter a valid amount.</span>');
				errors = 1;
			}
		}

		if (errors == 0) {

			jQuery('.check_no img').show();

			var post_data = {
				meter_no : field_meter_number,
				amount : field_amount
			}

			jQuery.ajax({
				url: "<?php echo get_option('home'); ?>/wp-json/ofy-remote/v1/post-meter-check",
				method: 'post',
				data: post_data,
				success: function(response){

					var response_arr = JSON.parse(response);

					if (response_arr.responseCode != 0) {

						// error
						jQuery('.check_no img').hide();
						jQuery('.field_meter_number').append('<span class="frm_error">There was an error while checking your credentials:<br><i>'+response_arr.responseMessage+'</i></span>');

					} else {

						// success
						jQuery('.check_no img').hide();
						jQuery('.field_meter_number').append('<span class="frm_message">'+response_arr.responseMessage+'</span>');

						jQuery('.field_how_pin').show();
						jQuery('.single_add_to_cart_button').show();

						// lock initial fields
						jQuery('.field_meter_number input').prop( "readonly", true );
						jQuery('.field_amount input').prop( "readonly", true );

					}
				}
			});
		}
	});

	window.setTimeout(function () {
	    jQuery('.nyp label').text('Enter amount (R10.00 – R3500.00)');
	    jQuery('.minimum-price').hide();
	}, 1000);

	window.setTimeout(function () {
	    jQuery('.nyp label').text('Enter amount (R10.00 – R3500.00)');
	    jQuery('.minimum-price').hide();
	}, 5000);

</script>
<?php } ?>