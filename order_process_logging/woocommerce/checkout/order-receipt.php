<?php
/**
 * Checkout Order Receipt Template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/order-receipt.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


?>

<div class="container">
    

    <!-- start: payment_intro -->
    <div class="payment_intro">
        <!-- start: payment-back -->
        <div class="btn payment-back flex" data-animatea="animated fadeInUp">
            <a href="#" class="button button-secondary" target="">
                <span class="hvr-back"><svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 7.5L9.72414 0.999998M2 7.5L9.72414 14M2 7.5L18 7.5" stroke="#FF5F00" stroke-width="2" />
                    </svg>
                </span>
                back
            </a>
        </div>
        <!-- end: payment-back -->
        <h1>Payment</h1>
    </div>
    <!-- end: payment_intro -->

    <div class="order-details-pay">
        <!-- start: left-col -->
        <div class="left-col">
            <div class="section">
                <h2>PAY WITH CREDIT OR DEBIT CARD</h2>
                <?php do_action( 'woocommerce_receipt_' . $order->get_payment_method(), $order->get_id() ); ?>
            </div>
        </div>
           <!-- end: left-col -->
<!--  start:  right-col-outer -->
        <div class="right-col-outer">
            <div class="right-col">
                <div class="order-summary">
                    <h3>Order Summary</h3>
                    <div class="summary-content">
                        <div class="summary-totals">
                            <div class="summary-order-no">
                                <span>Order Number</span>
                                <span class="woo-total">
                                    <?php echo esc_html( $order->get_order_number() ); ?>
                                </span>
                            </div>
                            <div class="summary-date">
                                <span>Date</span>
                                <?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?>
                            </div>
                            <div class="summary-method">
                                <span>Payment Method</span>
                                <?php echo wp_kses_post( $order->get_payment_method_title() ); ?>
                            </div>
                        </div>
                        <div class="sum-total"><span>Total: </span>
                            <span class="woo-total">
                                <?php echo wp_kses_post( $order->get_formatted_order_total() ); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end: right-col-outer -->

    </div>
</div>

<div>
    <?php

    $order_items = array();
    $order_items_i = 0;

    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

        $_product =  wc_get_product( $cart_item['data']->get_id());

        $order_items_i++;

        $order_items[$order_items_i] = array(
            'product_id' => $cart_item['data']->get_id(),
            'name' => $_product->get_title(),
            'total' => WC()->cart->cart_contents[$cart_item_key]['line_total'],
            'voucher-amount' => (WC()->cart->cart_contents[$cart_item_key]['line_total']/WC()->cart->cart_contents[$cart_item_key]['quantity']),
            'quantity' => WC()->cart->cart_contents[$cart_item_key]['quantity'],
            'how' => WC()->cart->cart_contents[$cart_item_key]['del_method'],
            'del-value' => WC()->cart->cart_contents[$cart_item_key]['del_value'],
            'sku' => $_product->get_sku()
        );

    }


    ?>
</div>



<div class="clear"></div>
