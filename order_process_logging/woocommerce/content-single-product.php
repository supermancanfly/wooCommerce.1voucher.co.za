<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>

<div class="data-bg" data-bg="theme-light-bg"></div>
<div class="section default-page black" id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

	<div class="container">

		<!-- start: buyvouchers-outer -->
		<div class="buyvouchers-outer buyvouchers-product-page">

			<?php if ( $product->get_ID() == ID_1FORYOU ) { ?>
			<!-- start: buyvouchers-left -->
			<div class="buyvouchers-left">
				<h6>buy a 1foryou voucher</h6>
				<h2>Follow these 3 easy steps to purchase and redeem a 1foryou voucher online.</h2>
			</div>
			<!-- end: buyvouchers-left -->
			<?php } else if ( $product->get_ID() == ID_ELECTRIC ) { ?>
			<!-- start: buyvouchers-left -->
			<div class="buyvouchers-left">
				<h6>buy an electricity voucher</h6>
				<h2>Follow these 3 easy steps to purchase an electricity voucher online.</h2>
			</div>
			<!-- end: buyvouchers-left -->
			<?php } ?>

			<!-- start: buyvouchers-right -->
			<div class="buyvouchers-right">

				<!-- start : buyvouchers -->
				<div class="buyvouchers">

					<ul class="buyvouchers_tabs">
						<li class="buyvouchers_tabs_type"><span>1</span><strong>Voucher</strong></li>
						<?php if ( $product->get_ID() == ID_1FORYOU ) { ?>
						<li class="buyvouchers_tabs_voucher active"><span>2</span><strong> Amount</strong></li>
						<?php } else if ( $product->get_ID() == ID_ELECTRIC ) { ?>
						<li class="buyvouchers_tabs_voucher active"><span>2</span><strong> Details</strong></li>
						<?php } ?>
						<li class="buyvouchers_tabs_payment"><span>3</span><strong>Payment Type</strong></li>
					</ul>

					<div class="buyvouchers_step2">

						<div class="steps-text">Step 2</div>

						<?php if ( $product->get_ID() == ID_1FORYOU ) { ?>
						<h3>Select your voucher amount</h3>
						<?php } else if ( $product->get_ID() == ID_ELECTRIC ) { ?>
						<h3>Enter your meter details</h3>
						<?php } ?>

						<?php
							/**
							 * Hook: woocommerce_before_single_product_summary.
							 *
							 * @hooked woocommerce_show_product_sale_flash - 10
							 * @hooked woocommerce_show_product_images - 20
							 */
							do_action( 'woocommerce_before_single_product_summary' );
						?>

						<div class="summary entry-summary">
							<?php
								/**
								 * Hook: woocommerce_single_product_summary.
								 *
								 * @hooked woocommerce_template_single_title - 5
								 * @hooked woocommerce_template_single_rating - 10
								 * @hooked woocommerce_template_single_price - 10
								 * @hooked woocommerce_template_single_excerpt - 20
								 * @hooked woocommerce_template_single_add_to_cart - 30
								 * @hooked woocommerce_template_single_meta - 40
								 * @hooked woocommerce_template_single_sharing - 50
								 * @hooked WC_Structured_Data::generate_product_data() - 60
								 */
								do_action( 'woocommerce_single_product_summary' );
							?>
						</div>

						<?php
							/**
							 * Hook: woocommerce_after_single_product_summary.
							 *
							 * @hooked woocommerce_output_product_data_tabs - 10
							 * @hooked woocommerce_upsell_display - 15
							 * @hooked woocommerce_output_related_products - 20
							 */
							do_action( 'woocommerce_after_single_product_summary' );
						?>

						<?php /*<a href="" class="goback goback_2">Back</a>*/ ?>

					</div>


				</div>
				<!-- end : buyvouchers -->

			</div>
			<!-- end : buyvouchers-right -->

		</div>
		<!-- end: buyvouchers-outer -->
	</div>

</div>
<div class="data-bg" data-bg="theme-light-bg"></div>

<div class="mobile_modal modal_2" style="display: none;">

	<div class="mobile_modal_in">

		<h6>Buy a 1ForYou Voucher</h6>

		<h2><?php the_field('title',1291); ?></h2>

		<?php the_field('content',1291); ?>

		<div class="modal_link">
			<a href="<?php echo get_option('home'); ?>/terms/#point_17" target="_blank">Terms and conditions apply</a>
		</div>

		<div class="modal_2_close">
			<img src="<?php bloginfo('stylesheet_directory'); ?>/images/modal_2_close.png" alt="">
		</div>

	</div>

</div>

<script>
jQuery(function($) {

	$('.important_info a').click( function(e) {
		e.preventDefault();
		$('.modal_2').fadeIn('fast');
	});

	$('.modal_2_close img').click( function(e) {
		e.preventDefault();
		$('.modal_2').fadeOut('fast');
	});

});

</script>

<?php do_action( 'woocommerce_after_single_product' ); ?>


