<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

//do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
// if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
//  echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
//  return;
// }

?>
<!-- <div class="data-bg" data-bg="theme-dark"></div> -->
<div class="data-bg" data-bg="theme-light-bg"></div>
<div class="checkout-container container">


    <!-- start: cart_nav in_page -->
    <div class="cart_nav in_page">
        <ul>
            <li class="cart_del_circle">
                <div class="circle"><span>1</span></div>
            </li>
            <li class="cart_del_text">Cart & Delivery</li>
            <li>
                <?php include (TEMPLATEPATH . '/images/vouchers/svg/chevron_right.svg'); ?>
            </li>
            <li class="cart_pay_circle">
                <div class="circle"><span>2</span></div>
            </li>
            <li class="cart_pay_text">Payment</li>
        </ul>
    </div>
    <div class="mobile_heading_cart">
        <h2>your cart</h2>
    </div>
    <div class="mobile_cart_info">
        <div class="items">2 Items</div>
        <div class="value">R550</div>
    </div>
    <!-- end: cart_nav in_page -->





    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
        <h1>PAYMENT</h1>
        <div class="checkout-details">
            <!-- start: left-col -->
            <div class="left-col">
                <div class="section">
                    <!--  <h2>Billing Details</h2> -->
                    <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
                    <div class="col2-set" id="customer_details">
                        <div class="col-1">
                            <?php do_action( 'woocommerce_checkout_billing' ); ?>
                        </div>
                    </div>
                    <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
                </div>
                <div class="section">
                    <h2>Payment Method</h2>
                    Your personal data will be used to process your order, support your experiece throughout this website, and for other purposes described in our <a href="">privacy policy</a>
                    <div id="order_review" class="woocommerce-checkout-review-order">
                        <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                    </div>
                </div>
            </div>
            <!-- end: left-col -->
            <!-- start: right-col-outer -->
            <div class="right-col-outer">
                <div class="right-col">


                    <div class="order-validation">
                        <ul id="validation-messages"></ul>
                    </div> 


                    <h3>Order Summary</h3>

                    <div class="summary-content">
                        <div class="summary-totals">
                            <div class="summary-total-sub">
                                <span>Subtotal</span>
                                <span>R
                                    <?php echo WC()->cart->subtotal; ?></span>
                            </div>
                            <div class="summary-total-discount">
                                <span>Discount</span>
                                <span>R
                                    <?php echo WC()->cart->discount; ?></span>
                            </div>
                        </div>
                        <div class="sum-total">
                            <span>Total: </span>
                            <span>R
                                <?php echo WC()->cart->total; ?></span>
                        </div>
                        <!-- start: style_checkboxes -->
                        <div class="style_checkboxes">
                            <div class="chk_item">
                                <input id="delivery-details" type="checkbox" /><label for="delivery-details">I confirm my delivery details are correct</label></div>
                            <div class="chk_item"> <input id="terms" type="checkbox" /> <label for="terms">I accept the <a href="">Terms & Conditions</a></label> </div>
                        </div>
                        <!-- end: style_checkboxes -->
                        <a class="button button-primary" id="complete-order" href="javascript:void(0);">Complete Order</a>
                        <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
                    </div>
                </div>
            </div>
            <!-- end: right-col-outer -->
        </div>
    </form>
</div>
<div class="container" style="display: none">
    <!-- start: buyvouchers-outer -->
    <div class="buyvouchers-outer">
        <!-- start: buyvouchers-left -->
        <div class="buyvouchers-left">
            <strong>buy a 1foryou voucher</strong>
            <h2>Follow these 3 easy steps to purchase and redeem a 1foryou voucher online.</h2>
        </div>
        <!-- end: buyvouchers-left -->
        <!-- start: buyvouchers-right -->
        <div class="buyvouchers-right">
            <!-- start : buyvouchers -->
            <div class="buyvouchers">
                <ul class="buyvouchers_tabs">
                    <li class="buyvouchers_tabs_voucher voucherchosen"><span> </span><strong>Voucher</strong></li>
                    <li class="buyvouchers_tabs_voucher voucherchosen"><span></span><strong> Amount</strong></li>
                    <li class="buyvouchers_tabs_payment active"><span>3</span><strong>Payment Type</strong></li>
                </ul>
                <div class="buyvouchers_step2">
                    <div class="steps-text">Step 3</div>
                    <h3>Select your payment type</h3>
                    <!--                    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="-->
                    <?php //echo esc_url( wc_get_checkout_url() ); ?>
                    <!--" enctype="multipart/form-data">-->
                    <div id="order_review" class="woocommerce-checkout-review-order">
                        <!--                            -->
                        <?php //do_action( 'woocommerce_checkout_order_review' ); ?>
                    </div>
                    <a href="javascript:window.history.back();" class="goback back_payment">Back</a>
                    <!--                        -->
                    <?php //do_action( 'woocommerce_checkout_after_order_review' ); ?>
                    <!--                    </form>-->
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
<style>
    .footer {
    width: 100%;
    float: left;
}

/*  .buyvouchers {
    padding: 30px;
}

.buyvouchers .buyvouchers_tabs {
    margin: 0 0 40px !important;
    padding: 0;
}

.buyvouchers .buyvouchers_tabs li {
    background: none;
    display: inline-block;
    margin: 0;
    padding: 4px 10px;
    list-style: none !important;
}

.buyvouchers .buyvouchers_tabs .active {
    border: 1px solid red;
}

.buyvouchers .buyvouchers_step_field {
    margin: 0 0 15px;
} */

</style>
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('#complete-order').on('click', function() {
        var FirstName = jQuery('#billing_first_name');
        var LastName = jQuery('#billing_last_name');
        var EmailAddress = jQuery('#billing_email');
        var DeliveryDetails = jQuery('#delivery-details');
        var Terms = jQuery('#terms');

        jQuery('#validation-messages').html('');

        if (jQuery(FirstName).val() === "") {
            jQuery('.order-validation').fadeIn(200);
            jQuery(FirstName).addClass('invalid');
        }else {
            jQuery(FirstName).removeClass('invalid');
        }

        if (jQuery(LastName).val() === "") {
            jQuery('.order-validation').fadeIn(200);
            jQuery(LastName).addClass('invalid');
        }else {
            jQuery(LastName).removeClass('invalid');
        }

        if (jQuery(EmailAddress).val() === "") {
            jQuery('.order-validation').fadeIn(200);
            jQuery(EmailAddress).addClass('invalid');
        }else {
            jQuery(EmailAddress).removeClass('invalid');
        }

        if (!$(DeliveryDetails).is(":checked")) {
            jQuery('.order-validation').fadeIn(200);
            jQuery('#validation-messages').append('<li>Please accept delivery details</li>');
        }

        if (!$(Terms).is(":checked")) {
            jQuery('.order-validation').fadeIn(200);
            jQuery('#validation-messages').append('<li>Please accept Terms</li>');
        }

        if (jQuery('#validation-messages').html() == '') {
            jQuery('.order-validation').fadeOut(200);
            jQuery('#place_order').click();
        } else {

        }


    });
});
</script>
<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>