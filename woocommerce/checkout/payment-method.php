<?php
/**
 * Output a single payment method
 *
 * This file is overridden of woocommerce/checkout/payment-method.php.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.5.0
 * Created By Yaroslav Danko
 * 2023/05/16
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if($gateway->title != 'Ozow'){
?>

<li class="wc_payment_method payment_method_<?php echo esc_attr( $gateway->id ); ?>">


	<input id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />

	<label for="payment_method_<?php echo esc_attr( $gateway->id ); ?>">
		<?php echo $gateway->get_title(); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?> <?php echo $gateway->get_icon(); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?>
	</label>
	<?php if ( $gateway->has_fields() || $gateway->get_description() ) : ?>
		<div class="payment_box payment_method_<?php echo esc_attr( $gateway->id ); ?>">
			<?php $gateway->payment_fields(); ?>
		</div>
	<?php endif; ?>
</li>
<?php
}
else{
?>
<li class="wc_payment_method payment_method_<?php echo esc_attr( $gateway->id ); ?>">

<fieldset>
	<div class="peachpayopt ozow" style="padding:5px 0; background-image: url(/wp-content/themes/onevoucher/images/vouchers/logos/logo_ozow_payment.png);">
	<input type="radio" id="payment_method_ipay" name="payment_method"  style="width:auto;" value="<?php echo esc_attr( $gateway->id ); ?>" >
	<label style="display:inline;" for="payment_method_ipay">Pay with Ozow</label>
	</div>
</fieldset>

</li>
<?php
}
?>