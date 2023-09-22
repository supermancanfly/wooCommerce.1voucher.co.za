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
<style>
    .checkout-details .left-col .style_checkboxes a {
        color: #f05e24;
    }
    .checkout-details .left-col .style_checkboxes .chk_item {
        margin-bottom: 8px;
        display: block;
        border: 1px solid #fff;
    }
    .checkout-details .left-col .style_checkboxes [type="checkbox"]:checked, .checkout-details .left-col .style_checkboxes [type="checkbox"]:not(:checked) {
        position: absolute;
        left: -9999px;
    }
    .checkout-details .left-col .style_checkboxes [type="checkbox"]:checked + label, .checkout-details .left-col .style_checkboxes [type="checkbox"]:not(:checked) + label {
        position: relative;
        padding-left: 28px;
        cursor: pointer;
        line-height: 20px;
        display: inline-block;
        color: #0c0c0c;
    }
    .checkout-details .left-col .style_checkboxes [type="checkbox"]:checked + label:before, .checkout-details .left-col .style_checkboxes [type="checkbox"]:not(:checked) + label:before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 20px;
        height: 20px;
        border: 1px solid #f26e25;
        border-radius: 3px;
        background: #fff;
    }
    .checkout-details .left-col .style_checkboxes [type="checkbox"]:checked + label:after, .checkout-details .left-col .style_checkboxes [type="checkbox"]:not(:checked) + label:after {
        content: '';
        width: 20px;
        height: 20px;
        background-color: #f26e25;
        background-position: center center;
        background-repeat: no-repeat;
        position: absolute;
        top: 0px;
        left: 0px;
        border-radius: 3px;
        -webkit-transition: all 0.2s ease;
        transition: all 0.2s ease;
        background-size: 11px auto;
        background-image: url('/wp-content/themes/onevoucher/images/svg/tick_small.svg');
    }
    .checkout-details .left-col .style_checkboxes [type="checkbox"]:not(:checked) + label:after {
        opacity: 0;
    }
    .checkout-details .left-col .style_checkboxes [type="checkbox"]:checked + label:after {
        opacity: 1;
    }
    .cart-page .left-cart .cart-products{
        margin-bottom: 25px;
    }
</style>
<!-- <div class="data-bg" data-bg="theme-dark"></div> -->
<div class="data-bg" data-bg="theme-light-bg"></div>
<div class="checkout-container container">


    <!-- start: cart_nav in_page -->
    <div class="cart_nav in_page">

        <div class="btn payment-back flex" data-animatea="animated fadeInUp">
            <a href="<?php echo get_option('home'); ?>/cart" class="button button-secondary" target="">
                <span class="hvr-back"><svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 7.5L9.72414 0.999998M2 7.5L9.72414 14M2 7.5L18 7.5" stroke="#FF5F00" stroke-width="2"></path>
                    </svg>
                </span>
                back
            </a>
        </div>
        
        <ul>
            <li class="cart_del_circle">
                <div class="circle"><span>1</span></div>
            </li>
            <li class="cart_del_text"><a href="<?php echo get_option('home'); ?>/cart">Cart & Delivery</a></li>
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
        <div class="items"><?php echo WC()->cart->get_cart_contents_count(); ?> Items</div>
        <div class="value"><?php echo WC()->cart->get_total();  ?></div>
    </div>
    <!-- end: cart_nav in_page -->





    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
        <h1>PAYMENT</h1>

        <div class="container" id="cart-page-empty" <?php if(WC()->cart->get_cart_contents_count() != 0){ ?> style="display: none;" <?php } ?>>
            <div class="cart_empty cart-page-empty">
                <h3>Your cart is empty</h3>
                <p>Browse available vouchers to get started.</p>
                <a href="<?php echo get_site_url(); ?>/shop-listing">buy vouchers</a>
            </div>
        </div>
        <div class="checkout-details cart-page "  id="cart-container">
            <!-- start: left-col -->
            <div class="left-col left-cart">
                <div class="section" style="display: none;">
                    <!--  <h2>Billing Details</h2> -->
                    <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

                    <div class="col2-set" id="customer_details">
                        <div class="col-1">
                            <?php //do_action( 'woocommerce_checkout_billing' ); ?>
                            <div class="woocommerce-billing-fields">

                                <h3>Order Details</h3>
                                <p>We need to capture your details so we can share the confirmation of your purchase with you</p>
                                <div class="billinfo">Personal Details</div>
                                <div class="frm_forms">
                                    <div class="flex_row">
                                        <div class="frm_none_container frm_form_field" id="billing_first_name_field" data-priority="10">
                                            <label for="billing_first_name" class="">First name</label>
                                            <input type="text" class="input-text " name="billing_first_name" id="billing_first_name" placeholder="First Name" value="First Name" autocomplete="given-name">
                                        </div>
                                        <div class="frm_none_container frm_form_field" id="billing_last_name_field" data-priority="20">
                                            <label for="billing_last_name" class="">Last name</label>
                                            <input type="text" class="input-text " name="billing_last_name" id="billing_last_name" placeholder="Last Name" value="Last Name" autocomplete="family-name">
                                        </div>
                                    </div>
                                    <!-- start: style_checkboxes -->
                                    <div class="style_checkboxes">
                                        <div class="chk_item">
                                            <input name="receive_invoice" type="checkbox" id="receive_invoice"  /><label for="receive_invoice">I would like to receive an invoice</label></div>
                            
                                    </div>
                                    <!-- end: style_checkboxes -->
                                    <!--
                                    <div style="display:none;">
                                    <div class="billinfo lower">Contact Details</div>
                                    <div class="cart-page">
                                        <div class="left-cart">
                                            <div class="cart_radios on_checkoutpage">
                                                <div class="delivery-option active">
                                                    <input type="radio" id="delivery_email" name="main_delivery_option" value="Email" checked="">
                                                    <label for="delivery_email">Email</label>
                                                    <input type="radio" id="delivery_sms" name="main_delivery_option" value="SMS">
                                                    <label for="delivery_sms">SMS</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex_row">
                                    <div class="frm_none_container frm_form_field" id="billing_email_field" data-priority="">
                                        <label for="billing_email" class="">Email Address</label>
                                        <input type="text" class="input-text " name="billing_email" id="billing_email" placeholder="Email Address" value="">
                                    </div>
                                    <div class="frm_none_container frm_form_field" id="billing_phone_field" data-priority="" style="display: none">
                                        <label for="billing_phone" class="">Phone</label>
                                        <input type="tel" class="input-text " name="billing_phone" id="billing_phone" placeholder="Phone" value="">
                                    </div>
                                    </div>
                                     </div>
                                    -->
                                    <p class="form-row form-row-wide" id="billing_peach_field" data-priority="">
                                        <span class="woocommerce-input-wrapper"><input type="hidden" class="input-hidden " name="billing_peach" id="billing_peach" value="dontsave"></span>
                                    </p>
                                </div>

                                </div>
                            </div>
                        </div>
                        <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
                    </div>
                    
                    <?php if(WC()->cart->get_cart_contents_count() != 0){ ?>
                    <div class="delivery-options">
                        <h3>Delivery Type</h3>
                        <ul id="delivery_type">
                            <li class="active">Single Delivery</li>
                            <li>Split Delivery</li>
                        </ul>
                        <div class="single-delivery-content delivery-option active">
                            <div class="text">
                                Send all vouchers to a single recipient. <br>
                                How would you like to send it?
                            </div>
                            <div class="cart_radios" style="display: none">
                                <input type="radio" id="delivery_email" name="main_delivery_option" value="Email" />
                                <label for="delivery_email">Email</label>
                                <input type="radio" id="delivery_sms" name="main_delivery_option" value="SMS" checked />
                                <label for="delivery_sms">SMS</label>
                            </div>
                            <!-- start:  deliver-email -->
                            <div class="frm_forms deliver-email" style="display: none">
                                <div class=" frm_none_container frm_form_field">
                                    <label for="" id="">Email Address</label>
                                    <input type="email" value="" placeholder="Email Address" id="billing_email" name="billing_email">
                                </div>
                            </div>
                            <!-- end:  deliver-email -->
                            <!-- start:  deliver-num -->
                            <div class="frm_forms deliver-num">
                                <div class=" frm_none_container frm_form_field">
                                    <div class="sms-validation"></div>
                                    <label for="" id="">Cellphone Number</label>
                                    <input type="tel" value="" placeholder="Cellphone Number" id="billing_phone" name="billing_phone">
                                </div>
                            </div>
                            <!-- end:  deliver-num -->
                            <!--         
                            <input type="email" placeholder="email here" class="deliver-email" />
                            <input type="text" placeholder="sms here" class="deliver-num" style="display: none" /> 
                            -->
                        </div>
                        <div class="split-delivery-content delivery-option">
                            <div class="text">
                                Send each voucher to a different recipient. <br>
                                Select the delivery method below.
                            </div>
                        </div>
                    </div>
                    
                    <div class="cart-products">
                        <?php

                        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                            $product = $cart_item['data'];
                            $product_id = $cart_item['product_id'];
                            $quantity = $cart_item['quantity'];
                            $price = WC()->cart->get_product_price( $product );
                            $cp = $cart_item['custom_price'];
                            $tags = get_the_terms( $product_id, 'product_tag' );
                            $tag_logo = get_field('tag_logo', 'product_tag_'.$tags[0]->term_id);
                            if(!$tag_logo){
                                $tag_logo = "https://place-hold.it/345x229?text=Image Pending&italic=true";
                            }

                            ?>
                        <div class="cart-item-checkout">


                            <!-- start: ca_holder -->
                            <div class="ca_holder">
                                <div class="ca_holder_img">
                                    <img src="<?php echo $tag_logo; ?>" />
                                </div>
                                <div class="ca_holder_info">
                                    <h3>
                                        <?php echo $tags[0]->name; ?>
                                    </h3>
                                    <div class="ca_info"><?php echo $product->description; ?></div>
                                    <div class="ca_holder_spinner_price">
                                    
                                        <div class="spinner">
                                            <button class="editcartitem" type="button">
                                                <span class="update-cart-prod" data-cart_key="<?php echo $cart_item_key; ?>" data-prod_quantity="<?php echo $quantity; ?>" data-prod_id="<?php echo $product_id; ?>"><span class="edit">Edit</span><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12.666 0.666992L15.3327 3.33366L8.66602 10.0003L4.66602 11.3337L5.99935 7.33366L12.666 0.666992Z" stroke="#1E2024" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M13.9993 11.3333V14C13.9993 14.3536 13.8589 14.6928 13.6088 14.9428C13.3588 15.1929 13.0196 15.3333 12.666 15.3333H1.99935C1.64573 15.3333 1.30659 15.1929 1.05654 14.9428C0.806491 14.6928 0.666016 14.3536 0.666016 14V3.33333C0.666016 2.97971 0.806491 2.64057 1.05654 2.39052C1.30659 2.14048 1.64573 2 1.99935 2H4.66602" stroke="#1E2024" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="price">
                                            <?php
                                            $prod_label = get_field('product_front_end_name', $product_id);

                                            if($cp) {
                                                echo $prod_label.' R'.$cp.'.00';
                                            } else {
                                                if($prod_label){
                                                    echo $prod_label.' - '.$price;
                                                } else {
                                                    echo $price;
                                                }

                                            } ?>
                                        </div>
                                    </div>
                                    <div onclick="removeProdCartItem(this)" data-prod_id="<?php echo $product_id; ?>" data-cart_key="<?php echo $cart_item_key; ?>" class="remove-prod remove">
                                    </div>
                                </div>

                            </div>
                            <!-- end: ca_holder -->


                            <div class="ca_holder_spinner_price mobile_view">
                                <div class="price">
                                    <?php
                                    if($cp) {
                                        echo 'R'.$cp.'.00';
                                    } else {
                                        echo $price;
                                    } ?>
                                </div>
                            </div>


                            <!-- start: split-delivery-options -->
                            <div class="split-delivery-options" data-key="<?php echo $cart_item_key; ?>" style="display: none">
                                <div style="display: none">
                                    <input name="delsys<?php echo $cart_item_key; ?>" type="radio" id="delivery_email<?php echo $cart_item_key; ?>" name="split_delivery_option<?php echo $product_id; ?>" value="Email"/>
                                    <label for="delivery_email<?php echo $cart_item_key; ?>">Email</label>
                                    <input name="delsys<?php echo $cart_item_key; ?>" type="radio" id="delivery_sms<?php echo $cart_item_key; ?>" name="split_delivery_option<?php echo $product_id; ?>" value="SMS" checked  />
                                    <label for="delivery_sms<?php echo $cart_item_key; ?>">SMS</label>
                                </div>
                                <br />
                                <br />
                                <!-- start:  deliver-email -->
                                <div class="frm_forms deliver-email" style="display: none">
                                    <div class=" frm_none_container frm_form_field">
                                        <label for="" id="">Email Address</label>
                                        <input type="email" value="" placeholder="Email Address">
                                    </div>
                                </div>
                                <!-- end:  deliver-email -->
                                <!-- start:  deliver-num -->
                                <div class="frm_forms deliver-num">
                                    <div class=" frm_none_container frm_form_field">
                                        <div class="sms-validation"></div>
                                        <label for="" id="">Cellphone Number</label>
                                        <input type="tel" value="" placeholder="Cellphone Number">
                                    </div>
                                </div>
                                <!-- end:  deliver-num -->
                                <!--   
                                    <input type="email" class="deliver-email">
                                    <input type="text" class="deliver-num" style="display: none">
                                -->
                            </div>
                            <!-- end: split-delivery-options -->








                        </div>
                        <?php } ?>
                    </div>
                        

                    
                    <?php } ?>
                    <div class="section">
                        <h2>Payment Method</h2>
                        Please note we do not accept Standard Bank card purchases. Your personal data will be used to process your order, support your experience throughout this website, and for other purposes des
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
                                <span class="woo-total">R<?php echo WC()->cart->subtotal; ?></span>
                            </div>
                            <div class="summary-total-discount">
                                <span>Discount</span>
                                <span>R<?php echo WC()->cart->get_discount_total(); ?></span>
                            </div>
                        </div>
                        <div class="sum-total">
                            <span>Total: </span>
                            <span class="woo-total">R
                                <?php echo WC()->cart->total; ?></span>
                        </div>
                        <!-- start: style_checkboxes -->
                        <!-- <div class="style_checkboxes"> -->
                            <!-- <div class="chk_item"> -->
                            <!-- <div class="chk_item"> <input id="terms" type="checkbox" /> <label for="terms">I accept the <a target="_blank" href="https://www.1voucher.co.za/terms-conditions">Terms & Conditions</a></label> </div> -->
                             <!-- <div class="chk_item"> <input id="marketing" type="checkbox" /> <label for="marketing">Sign up for the latest 1Voucher deals</label> </div> -->
                        <!-- </div> -->
                        <!-- end: style_checkboxes -->
                        <p>
                        By submitting your order you agree to our <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a>
                        </p>
                        <a class="button button-primary" id="complete-order" href="javascript:void(0);">Pay Now</a>
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

    // jQuery('.delivery-option input').on('click', function() {
    //     if (jQuery('#delivery_sms').is(':checked')) {
    //         jQuery('#billing_email_field').hide();
    //         jQuery('#billing_phone_field').show();
    //     }
    //     if (jQuery('#delivery_email').is(':checked')) {
    //         jQuery('#billing_email_field').show();
    //         jQuery('#billing_phone_field').hide();
    //     }
    // });

    jQuery('#complete-order').on('click', function() {
        var FirstName = jQuery('#billing_first_name');
        var LastName = jQuery('#billing_last_name');
        var EmailAddress = jQuery('#billing_email');
         var Phone = jQuery('#billing_phone');

        valid = false;
        jQuery('.order-validation').fadeOut(0);

        jQuery('#validation-messages').html('');

        if (jQuery(FirstName).val() === "") {
            jQuery('.order-validation').fadeIn(200);
            jQuery(FirstName).addClass('invalid');
            jQuery(FirstName).parent().addClass('invalid-message');
            jQuery(FirstName).parent().attr('data-message','Error: Please enter a valid name');
        }else {
            jQuery(FirstName).removeClass('invalid');
            jQuery(FirstName).parent().removeClass('invalid-message');
            valid = true;
        }

        if (jQuery(LastName).val() === "") {
            jQuery('.order-validation').fadeIn(200);
            jQuery(LastName).addClass('invalid');
            jQuery(LastName).parent().addClass('invalid-message');
            jQuery(LastName).parent().attr('data-message','Error: Please enter a valid last name');
        }else {
            jQuery(LastName).removeClass('invalid');
            jQuery(LastName).parent().removeClass('invalid-message');
            valid = true;
        }
        if (jQuery('#delivery_type .active').text() == 'Single Delivery') {
            if (jQuery('#delivery_sms').is(':checked')) {
                console.log($(Phone).val().length)
                if ($(Phone).val().length == 0 || $(Phone).val().length !== 10) {

                    if($(Phone).val().length == 0 || $(Phone).val().length !== 10) {
                        // $('.sms-validation').text('Please make sure your phone number has 10 numbers');
                        $(Phone).addClass('invalid');
                        $(Phone).parent().attr('data-message', 'Error: Please make sure your phone number has 10 numbers');
                        $(Phone).parent().addClass('invalid-message');
                        valid = false;
                    } else {
                        jQuery('.order-validation').fadeIn(200);
                        jQuery(Phone).addClass('invalid');
                        jQuery(Phone).parent().addClass('invalid-message');
                        jQuery(Phone).parent().attr('data-message','Error: Please enter a valid phone number');
                    valid = false;
                    }
                }else {
                    jQuery(Phone).removeClass('invalid');
                    jQuery(Phone).parent().removeClass('invalid-message');
                    valid = true;
                }
            }
            if (jQuery('#delivery_email').is(':checked')) {
                if (jQuery(EmailAddress).val() === "") {
                    jQuery('.order-validation').fadeIn(200);
                    jQuery(EmailAddress).addClass('invalid');
                    jQuery(EmailAddress).parent().addClass('invalid-message');
                    jQuery(EmailAddress).parent().attr('data-message','Error: Please enter a valid email address');
                    valid = false;
                }else {
                    jQuery(EmailAddress).removeClass('invalid');
                    jQuery(EmailAddress).parent().removeClass('invalid-message');
                    valid = true;
                }
            }
        }
        else{

        }





        // if (!$(DeliveryDetails).is(":checked")) {
        //     jQuery('.order-validation').fadeIn(200);
        //     jQuery('#validation-messages').append('<li>Please accept delivery details</li>');
        //     valid = false;
        // }

        if (jQuery('#validation-messages').html() == '' && valid == true) {
            jQuery('.order-validation').fadeOut(200);
            saveCartData()
            
        } else {

        }



    });
    function saveCartData(){
        jQuery('#validation-messages').html('');
        // 1. CHECK IF SPLIT OR SINGLE DELIVERY METHOD

        if (jQuery('#delivery_type .active').text() == 'Single Delivery') {

            var DeliveryType = 'Single';
            var DeliveryMethod = jQuery('input[name=main_delivery_option]:checked').val();

            if (DeliveryMethod == 'Email') {
                var DeliveryMethodValue = jQuery('#billing_email').val();
            } else {
                var DeliveryMethodValue = jQuery('#billing_phone').val();
            }

        } else {
            var DeliveryType = 'Split';
        }

        // 2. IF SINGLE DELIVERY
        //     a.VALIDATE IF INPUT DATA IS VALID
        //     b.LOOP THROUGH CART ITEMS AND UPDATE DELIVERY OPTION META DATA BASED ON MAIN INPUTS
        //     c.LOOP THROUGH CART ITEMS AND UPDATE QUANTITIES IF THEY CHANGED

        var cartDetails = document.getElementById('delivery_type');

        if (DeliveryType == 'Single') {
            jQuery('.right-col').addClass('loading-next');
            jQuery.ajax({
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                type: 'POST',
                data: {
                    action: 'getupdateOrderMeta',
                    delType: DeliveryType,
                    delMethod: DeliveryMethod,
                    delValue: DeliveryMethodValue
                },
                dataType: 'html',
                success: function(response) {
                    console.log(response)
                    jQuery('.right-col').removeClass('loading-next');
                    jQuery('.right-col').removeClass('loading-next');
                    jQuery('#place_order').click();
                },
                error: function() {
                    jQuery('.right-col').removeClass('loading-next');
                }

            });
        } else {

            // 2. IF SPLIT DELIVERY
            //     a.LOOP THROUGH EACH PRODUCT IN CART AND VALIDATE IF INPUT DATA IS VALID
            //     b.LOOP THROUGH ALL PRODUCTS IN CART AND UPDATE WITH CART SPECIFIC ITEM DATA
            //     c.LOOP THROUGH CART ITEMS AND UPDATE QUANTITIES IF THEY CHANGED

            const cart_items = [];

            var valid = true;
            jQuery('.split-delivery-options').each(function() {
                var cart_item = jQuery(this).attr('data-key');
                var cart_item_del_sys = jQuery("input[name='delsys" + cart_item + "']:checked").val();

                if (cart_item_del_sys == "Email") {

                    if(isEmail(jQuery(this).find('.deliver-email input').val()) == false){
                        jQuery(this).find('.deliver-email input').addClass('invalid');
                        window.scroll({
                            top: 100,
                            behavior: 'smooth'
                        });
                        valid = false;
                        return false;
                    } else {
                        valid = true;
                        jQuery(this).find('.deliver-email input').removeClass('invalid');
                    }

                    var cart_item_del_val = jQuery(this).find('.deliver-email input').val();

                } else {

                    if(jQuery(this).find('.deliver-num input').val().length == 0 || jQuery(this).find('.deliver-num input').val().length != 10){
                        $('.deliver-num .sms-validation').text('Please make sure your phone number has 10 numbers');

                        jQuery(this).find('.deliver-num input').addClass('invalid');
                        window.scroll({
                            top: 100,
                            behavior: 'smooth'
                        });
                        valid = false;
                        return false;
                    }else {
                        valid = true;
                        $('.deliver-num .sms-validation').text('');
                        jQuery(this).find('.deliver-num input').removeClass('invalid');
                    }

                    var cart_item_del_val = jQuery(this).find('.deliver-num input').val();
                }


                cart_items.push(cart_item + '|' + cart_item_del_val + '|' + cart_item_del_sys);

            });

            if(valid == false){
               
                return false;
            }
            console.log(valid);
            jQuery('.right-col').addClass('loading-next');
            jQuery.ajax({
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                type: 'POST',
                data: {
                    action: 'getupdateOrderMeta',
                    delType: DeliveryType,
                    cartItems: cart_items
                },
                dataType: 'html',
                success: function(response) {
                    console.log(response)
                    jQuery('.right-col').removeClass('loading-next');
                    jQuery('.right-col').removeClass('loading-next');
                    jQuery('#place_order').click();
                },
                error: function() {
                    console.log('nono');
                    jQuery('.right-col').removeClass('loading-next');
                }

            });

        }


        // 3. AFTER ORDER DATA HAS BEEN UPDATE REDIRECT PAGE TO CHECKOUT
    }
});
</script>
<script type="text/javascript">

    jQuery('.deliver-num input').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    jQuery(document).ready(function() {

        jQuery('.delivery-option input').on('click', function() {
            if (jQuery('#delivery_sms').is(':checked')) {
                jQuery('.deliver-email').hide();
                jQuery('.deliver-num').show();
            }
            if (jQuery('#delivery_email').is(':checked')) {
                jQuery('.deliver-email').show();
                jQuery('.deliver-num').hide();
            }
        });

        jQuery('#delivery_type li').on('click', function() {
            jQuery('#delivery_type li').toggleClass('active');
            jQuery('.delivery-option').toggleClass('active');
            jQuery('.split-delivery-options').toggle('fast');
        });

        jQuery('.split-delivery-options input[type=radio]').on('click', function() {
            var del_options = jQuery(this).parent();
            jQuery(del_options).find('.deliver-email').toggle();
            jQuery(del_options).find('.deliver-num').toggle();
        });

    });

    
    const validateEmail = (email) => {
        return email.match(
            /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        );
    };

    function removeProdCartItem(e) {
        $(e).parent().parent().addClass('focus');
        jQuery.ajax({
            type: "post",
            dataType: "json",
            url: my_ajax_object.ajax_url,
            data : {action: "delete_cart_item", id: $(e).attr('data-product_id'), key: $(e).attr('data-cart_key')},
            success: function(data){
                if(data.state == true){
                    $(e).parent().parent().parent().fadeOut().remove();
                    getcartDetails();
                }
            },
            error: function(msg){

            }
        });
    }
</script>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>