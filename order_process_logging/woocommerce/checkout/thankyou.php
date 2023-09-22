<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="woocommerce-order">
    <?php if ( $order ) {

		do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>
    <?php if ( $order->has_status( 'failed' ) ) { ?>
    <!-- start: payment-success-fail   FAIL -->
    <div class="payment-success-fail">
        <div class="container">
            <div class="icon-top failed">
                <?php include (TEMPLATEPATH . '/images/svg/icon_error.svg'); ?>
                <strong> Payment Unsuccessful</strong>
            </div>
            <h2>Something went wrong</h2>
            <div class="payment_info">
                <p>Email us at <a href="mailto:support@1foryou.com">support@1foryou.com</a> you are having issue with the voucher.</p>
                <p>
                    Please note: This email address is only to query 1ForYou vouchers purchased<br>
                    on this site. For any other queries relating to 1ForYou please contact us on<br>
                    <a href="mailto:hello@1foryou.com">hello@1foryou.com</a>
                </p>
            </div>
            <a href="<?php echo get_option('home'); ?>/buy-a-voucher/" class="button button-primary">Buy a 1ForYou voucher</a>
        </div>
    </div>
    <!-- end: payment-success-fail -->
    <div style="display:none">
        <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed">
            <?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?>
        </p>
        <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
            <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay">
                <?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
            <?php if ( is_user_logged_in() ) { ?>
            <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay">
                <?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
            <?php } ?>
        </p>
    </div>
    <?php } else { ?>
    <?php
				foreach ( $order->get_items() as $item_key => $item ) {
					$product = $order->get_product_from_item( $item );
					$thesku = $product->get_sku();
					$thesku = trim(preg_replace('/[\t|\s{2,}]/', '', $thesku));
					break;
				}
			?>
    <!-- start: payment-success-fail SUCCESS -->
    <div class="payment-success-fail thanks-page">
        <div id="success-message">
            <h1>Payment Successful!</h1>
            <p>Your vouchers will be delivered shortly. <br>
                You will also receive redemption instructions with the voucher.</p>
            <!-- start: share-continue -->
            <div class="btn share-continue flex" data-animatea="animated fadeInUp">
                <a href="<?php echo get_site_url(); ?>/shop-listing" class="button button-secondary" target="">
                    SHARE order<span class="hvr-forward"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.668 5.33333C14.1346 5.33333 15.3346 4.13333 15.3346 2.66667C15.3346 1.2 14.1346 0 12.668 0C11.2013 0 10.0013 1.2 10.0013 2.66667C10.0013 2.93333 10.068 3.13333 10.1346 3.33333L5.26797 6.13333C4.73464 5.66667 4.06797 5.33333 3.33464 5.33333C1.86797 5.33333 0.667969 6.53333 0.667969 8C0.667969 9.46667 1.86797 10.6667 3.33464 10.6667C4.06797 10.6667 4.73464 10.3333 5.26797 9.86667L10.1346 12.6667C10.068 12.8667 10.0013 13.1333 10.0013 13.3333C10.0013 14.8 11.2013 16 12.668 16C14.1346 16 15.3346 14.8 15.3346 13.3333C15.3346 11.8667 14.1346 10.6667 12.668 10.6667C11.9346 10.6667 11.268 11 10.7346 11.4667L5.86797 8.66667C5.93464 8.46667 6.0013 8.26667 6.0013 8C6.0013 7.73333 5.93464 7.53333 5.86797 7.33333L10.7346 4.53333C11.268 5 11.9346 5.33333 12.668 5.33333Z" fill="#F05E24" />
                        </svg>
                    </span>
                </a>
            </div>
            <!-- end: share-continue -->
        </div>
        <div class="container thanks-flex" id="cart-container">

            <div class="left-thanks">
                <div class="delivery-options">
                    <h3>Your Order</h3>
                    <div class="order-items">
                        <?php


                                $count = 0;
                                foreach ( $order->get_items() as $item_key => $item ) {
                                    $count++;
                                    $order_meta = $order->get_meta('Cart_ID_'.$count);
                                    $order_delivery_method = $order->get_meta('DelValue - '.$order_meta);
                                    $voucher_code = $order->get_meta('serialNumber - '.$order_meta);
                                    $voucher_exp = $order->get_meta('VoucherExpiry - '.$order_meta);
                                    $product_id = $item->get_product_id();
                                    $product_title = get_the_title($product_id);
                                    $quantity = $item->get_quantity();
                                    $total = $item->get_total();
                                    $order_meta = $item->get_meta('_Cart_ID_1');
                                    $terms = get_the_terms( $product_id, 'product_tag' );
                                    $tag_logo = get_field('tag_logo', 'product_tag_'.$terms[0]->term_id);
                                    $trans_id = wc_get_order_item_meta( $item_key, 'Cart_ID_1', true );
                                    $serial = wc_get_order_item_meta( $item_key, 'serialNumber', true );
                                    if(!$tag_logo){
                                        $tag_logo = "https://place-hold.it/345x229?text=Image Pending&italic=true";
                                    }
                                    ?>
                        <!-- start: order-item -->
                        <div class="order-item">
                            <div class="order-img">
                                <div class="img_box"><img src="<?php echo $tag_logo; ?>" /></div>
                                <div class="right_info">
                                    <strong>
                                        R<?php echo $total; ?></strong>
                                    <span>QTY:
                                        <?php echo $quantity; ?></span>
                                </div>
                            </div>
                            <div class="order-info">
                                <div class="row-top">
                                    <div class="left_info">
                                        <strong>
                                            <?php echo $product_title; ?></strong>
                                        <span>static: 2 month membership(R190)</span>
                                    </div>
                                    <div class="right_info">
                                        <strong> R
                                            <?php echo $total; ?></strong>
                                        <span>QTY:
                                            <?php echo $quantity; ?></span>
                                    </div>
                                </div>
                                <div class="row-info">
                                    <div class="info-col"> <span> Voucher number</span>
                                        <?php echo $voucher_code; ?>
                                    </div>
                                    <div class="info-col"> <span>Voucher Expiry</span>
                                        <?php echo $voucher_exp; ?>
                                    </div>
                                    <div class="info-col"> <span> Delivered to</span>
                                        <?php echo $order_delivery_method; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end: order-item -->
                        <?php }
									                                ?>
                    </div>
                </div>
                <!-- start: thankyou_lower -->
                <div class="thankyou_lower for_desktop">
                    <div class="left">
                        <span>Need help?</span>
                        <div class="btn shop-continue flex" data-animatea="animated fadeInUp">
                            <a href="<?php echo get_site_url(); ?>/shop-listing" class="button button-secondary" target="">
                                contact us<span class="hvr-forward"><svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16 7.5L8.27586 14M16 7.5L8.27586 1M16 7.5L6.6955e-07 7.5" stroke="#F05E24" stroke-width="2"></path>
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="right"><a href="/home" class="button button-primary">Return to home</a></div>
                </div>
                <!-- end: thankyou_lower -->
            </div>

            <div class="right-thanks-outer">
                <div class="right-thanks">
                    <h3>Order Summary</h3>
                    <!-- start: summary-content -->
                    <div class="summary-content">
                        <div class="summary-totals">
                            <div class="summary-order-no">
                                <span>Order Number:</span>
                                <span>
                                    <?php echo $order->get_id(); ?></span>
                            </div>
                            <div class="summary-date">
                                <span>Date:</span>
                                <span>
                                    <?php echo explode('T',$order->get_date_paid())[0]; ?></span>
                            </div>
                            <div class="summary-paymethod">
                                <span>Payment Method:</span>
                                <span>
                                    <?php echo $order->get_payment_method_title(); ?></span>
                            </div>
                        </div>
                        <div class="sum-total">
                            <span>Total: </span>
                            <span>R
                                <?php echo $order->get_total(); ?></span>
                        </div>
                    </div>
                    <!-- end: summary-content -->
                    <!--     
<hr/>
Order Number : <?php //echo $order->get_id(); ?><br/>
Date : <?php //echo $order->get_date_paid(); ?><br/>
Payment Method : <?php //echo $order->get_payment_method_title(); ?><br/>
<hr/>
Total : 
-->
                </div>
            </div>
            <!-- start: thankyou_lower -->
            <div class="thankyou_lower for_mobile">
                <div class="left">
                    <span>Need help?</span>
                    <div class="btn shop-continue flex" data-animatea="animated fadeInUp">
                        <a href="<?php echo get_site_url(); ?>/shop-listing" class="button button-secondary" target="">
                            contact us<span class="hvr-forward"><svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 7.5L8.27586 14M16 7.5L8.27586 1M16 7.5L6.6955e-07 7.5" stroke="#F05E24" stroke-width="2"></path>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="right"><a href="/home" class="button button-primary">Return to home</a></div>
            </div>
            <!-- end: thankyou_lower -->
            <!--					<div class="icon-top success">-->
            <!--						-->
            <?php //include (TEMPLATEPATH . '/images/svg/icon_success.svg'); ?>
            <!--						-->
            <?php //if ($thesku == 'ELECTRIC') { ?>
            <!--						<strong> Request Successful</strong>-->
            <!--						-->
            <?php //} else { ?>
            <!--						<strong> Payment Successful</strong>-->
            <!--						-->
            <?php //} ?>
            <!--					</div>-->
            <!---->
            <!--					<h2>Thanks for your purchase</h2>-->
            <!--                    -->
            <!--					<div class="payment_info">-->
            <!---->
            <!--						<p>-->
            <!--							<strong>Order reference:</strong> -->
            <?php //$serialno = get_post_meta($order->get_id().'1FORYOU_purchase_serialno'); echo $serialno[0]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            <!-- -->
            <!--							<span class="serial"></span><br>-->
            <!--							<span class="token"></span>-->
            <!--						</p>-->
            <!--						<p>-->
            <!--							-->
            <?php //if (trim($thesku ) == 'ELECTRIC') { ?>
            <!--							Your electricity voucher has been successfully sent. <br>-->
            <!--							-->
            <?php //} else { ?>
            <!--							Your 1ForYou voucher has been successfully sent. <br>-->
            <!--							-->
            <?php //} ?>
            <!--							Total: -->
            <?php //echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            <!--						</p>-->
            <!--						<p>-->
            <!--							<a href="mailto:support@1foryou.com" style="color: #000; text-decoration: none;">support@1foryou.com</a>-->
            <!--						</p>-->
            <!---->
            <!--					</div>-->
            <!--					<a href="-->
            <?php //echo get_option('home'); ?>
            <!--" class="button button-primary">Return to home</a>-->
        </div>
    </div>
    <!-- end: payment-success-fail -->
    <?php if ($thesku != 'ELECTRIC') { ?>
    <script>
    setTimeout(function() {

        var post_data = {
            key: '<?php echo nfh_encode_orderid($order->get_order_number()); ?>'
        }

        jQuery.ajax({
            url: "<?php echo get_option('home'); ?>/wp-json/nfh-remote/v1/get-token-thankyou",
            method: 'post',
            data: post_data,
            success: function(response) {
                console.log(response);
                if (response != 'error') {
                    jQuery('span.token').html('<strong>Your 1ForYou Pin:</strong> ' + response);
                }
            }
        });

        jQuery.ajax({
            url: "<?php echo get_option('home'); ?>/wp-json/nfh-remote/v1/get-token-thankyou2",
            method: 'post',
            data: post_data,
            success: function(response) {
                console.log(response);
                if (response != 'error') {
                    jQuery('span.serial').html('<strong>Order reference:</strong> ' + response);
                }
            }
        });

    }, 3000)
    </script>
    <?php } ?>
    <div style="display:none">
        <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">
            <?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), $order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </p>
        <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">
            <li class="woocommerce-order-overview__order order">
                <?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
                <strong>
                    <?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
            </li>
            <li class="woocommerce-order-overview__date date">
                <?php esc_html_e( 'Date:', 'woocommerce' ); ?>
                <strong>
                    <?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
            </li>
            <?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
            <li class="woocommerce-order-overview__email email">
                <?php esc_html_e( 'Email:', 'woocommerce' ); ?>
                <strong>
                    <?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
            </li>
            <?php endif; ?>
            <li class="woocommerce-order-overview__total total">
                <?php esc_html_e( 'Total:', 'woocommerce' ); ?>
                <strong>
                    <?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
            </li>
            <?php if ( $order->get_payment_method_title() ) : ?>
            <li class="woocommerce-order-overview__payment-method method">
                <?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
                <strong>
                    <?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
            </li>
            <?php endif; ?>
        </ul>
    </div>
    <script>
    jQuery(function($) {
        var retrievedfields = localStorage.getItem('buyfields');
        var fieldsobj = JSON.parse(retrievedfields);
        if (fieldsobj != null) {
            localStorage.removeItem("buyfields");
        }
    });
    </script>
    <?php } ?>
    <?php //do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
    <?php //do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
    <?php } else { ?>
    <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">
        <?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
    </p>
    <?php } ?>
</div>