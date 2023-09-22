<?php
/*
	Template Name: Buy Vouchers
*/


if ( !is_user_logged_in() ) {
	//exit;
}

function set_custom_price($cart_obj) {

	foreach ($cart_obj->get_cart() as $key => $value) {
		if ($value['product_id'] == 1302) {
			$value['data']->set_price(9.90);
		   // $new_price = $value['data']->get_price();
		}
	}
}
add_action('woocommerce_before_calculate_totals', 'set_custom_price');

// if (!isset($_GET['lock']) || $_GET['lock'] != '0ne4u') {
// 	exit;
// }


// if (isset($_GET['salesetup']) && $_GET['salesetup'] == 'process') {

// 	global $woocommerce, $nf;

// 	$validKeys = array(
// 		'buyvouchers_1fa_vtype',
// 		'buyvouchers_1fa_type',
// 		'buyvouchers_1fa_custom',
// 		'buyvouchers_1fa_receive',
// 		'buyvouchers_1fa_email',
// 		'buyvouchers_1fa_mobile'
// 	);

// 	$post_data = $nf->clean_multi_array($_POST, $validKeys);
// 	$post_data_json = json_encode($post_data);

// 	if (isset($post_data) && !empty($post_data)) {

// 		$woocommerce->cart->empty_cart();

// 		if ($post_data['buyvouchers_1fa_type'] == 'R20') {
// 			$woocommerce->cart->add_to_cart( 1299, 1 );
// 		} else if ($post_data['buyvouchers_1fa_type'] == 'R50') {
// 			$woocommerce->cart->add_to_cart( 1300, 1 );
// 		} else if ($post_data['buyvouchers_1fa_type'] == 'R100') {
// 			$woocommerce->cart->add_to_cart( 1301, 1 );
// 		} else if ($post_data['buyvouchers_1fa_type'] == 'RVAR') {
// 			$cart_item_data = array('custom_price' => $post_data['buyvouchers_1fa_custom']);
// 			$woocommerce->cart->add_to_cart( 1302, 1, '', '', $cart_item_data );
// 			$woocommerce->cart->calculate_totals();
// 			$woocommerce->cart->set_session();
// 			$woocommerce->cart->maybe_set_cart_cookies();
// 		}

// 		$formjson = urlencode( $post_data_json );
// 		unset($_SESSION["nfh_order_info"]);
// 		$_SESSION["nfh_order_info"] = $formjson;

// 		if (isset($_SESSION["nfh_order_info"]) && !empty($_SESSION["nfh_order_info"])) {
// 			echo 'success';
// 		} else {
// 			echo 'fail';
// 		}

// 	} else {
// 		echo 'fail';
// 	}

// 	exit;

// }

get_header(); ?>

<?php if (have_posts()) { while (have_posts()) { the_post(); ?>

<div class="data-bg" data-bg="theme-light-bg"></div>
<div class="section default-page white-bg">

	<div class="container">

		<!-- start: buyvouchers-outer -->
		<div class="buyvouchers-outer">

			<!-- start: buyvouchers-left -->
			<div class="buyvouchers-left">

				<h6>Buy a 1ForYou Voucher</h6>
				<h2><?php the_field('title'); ?></h2>
				<div class="spacer"></div>
				<?php the_field('content'); ?>

				<a href="<?php echo get_option('home'); ?>/terms/#point_17" target="_blank">Terms and conditions apply</a>

			</div>
			<!-- end: buyvouchers-left -->

			<!-- start: buyvouchers-right -->
			<div class="buyvouchers-right">

				<!-- start : buyvouchers -->
				<div class="buyvouchers">

					<ul class="buyvouchers_tabs">
						<li class="buyvouchers_tabs_type active"><span>1</span><strong>Voucher</strong></li>
						<li class="buyvouchers_tabs_voucher"><span>2</span><strong> Amount</strong></li>
						<li class="buyvouchers_tabs_payment"><span>3</span><strong>Payment Type</strong></li>
					</ul>

					<div class="buyvouchers_step1">

						<div class="steps-text">Step 1</div>

						<h3>Select your voucher type</h3>

						<div class="buyvouchers_step_field buyvouchers_1fa_vtype">
							<!-- <label for="buyvouchers_1fa_vtype">Voucher type</label><br> -->
							<select name="buyvouchers_1fa_vtype" id="buyvouchers_1fa_vtype" class="custom-options">
								<option value="">Voucher type</option>
								<option value="1FORYOU" class="icon_1foryou">1FORYOU VOUCHER</option>
								<option value="ELECTRICITY">ELECTRICITY</option>
								<!-- <option value="UBER">UBER</option>
								<option value="UBEREATS">UBEREATS</option>
								<option value="NETFLIX">NETFLIX</option> -->
							</select>
						</div>

						<!-- <div class="buyvouchers_step2_error error"></div> -->
						<p class="important_info"><a href="">Payment Tips</a></p>

						<button class="buyvouchers_step1_next button button-primary inactive">Next Step</button>

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


<div class="mobile_modal modal_1">

	<div class="mobile_modal_in">

		<h6>Buy a 1ForYou Voucher</h6>

		<h2><?php the_field('title'); ?></h2>

		<?php the_field('content'); ?>

		<div class="modal_link">
			<a href="<?php echo get_option('home'); ?>/terms/#point_17" target="_blank">Terms and conditions apply</a>
		</div>

		<div class="modal_continue">
			<a href="" class="">Continue</a>
		</div>

	</div>

</div>

<div class="mobile_modal modal_2" style="display: none;">

	<div class="mobile_modal_in">

		<h6>Buy a 1ForYou Voucher</h6>

		<h2><?php the_field('title'); ?></h2>

		<?php the_field('content'); ?>

		<div class="modal_link">
			<a href="<?php echo get_option('home'); ?>/terms/#point_17" target="_blank">Terms and conditions apply</a>
		</div>

		<div class="modal_2_close">
			<img src="<?php bloginfo('stylesheet_directory'); ?>/images/modal_2_close.png" alt="">
		</div>

	</div>

</div>

	<style>
		.selectric-open .selectric-scroll ul li:first-child {
			display: none;
		}
		.woocommerce-privacy-policy-link {
			color: #fff !important;
		}
	</style>

	<script>
	jQuery(function($) {

		$('.buyvouchers button.disabled').click( function(e) {
			e.preventDefault();
		});

		$('.buyvouchers_step1_next').click( function(e) {
			e.preventDefault();

			var testing = $('#buyvouchers_1fa_vtype option:selected').val();
			console.log(testing);

			if ($(this).hasClass('inactive')) {
				return;
			} else {

				$('.buyvouchers_tabs > li').removeClass('active');
				// $('.buyvouchers_tabs .buyvouchers_tabs_type').addClass('voucherchosen');
				// $('.buyvouchers_tabs .buyvouchers_tabs_voucher').addClass('active');



				if ( $('#buyvouchers_1fa_vtype option:selected').val() == '1FORYOU' ) {

					window.location.href = "<?php echo get_option('home'); ?>/product/1foryou-voucher/";

				}

				if ( $('#buyvouchers_1fa_vtype option:selected').val() == 'ELECTRICITY' ) {

					window.location.href = "<?php echo get_option('home'); ?>/product/electricity-voucher/";

				}
			}

		});

		// voucher type
		if( $('#buyvouchers_1fa_vtype').has('option').length > 0 ) {

			if ( $('#buyvouchers_1fa_vtype option:selected').val() == '1FORYOU' ) {

				$('.buyvouchers_step1_next').removeClass('inactive');
			} else if ( $('#buyvouchers_1fa_vtype option:selected').val() == 'ELECTRICITY' ) {

				$('.buyvouchers_step1_next').removeClass('inactive');
			}
		}

		$('.modal_continue a').click( function(e) {
			e.preventDefault();
			$('.modal_1').fadeOut('fast');
		});

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

	<style>
		.mobile_modal {
			display: none !important;
		}
	</style>

<?php } } ?>

<?php get_footer(); ?>