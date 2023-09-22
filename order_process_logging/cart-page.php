<?php
/*
    Template Name: Shop Cart
*/

get_header();

global $woocommerce;
?>


<div class="data-bg" data-bg="theme-light-bg"></div>
<div class="section default-page black cart-page">
    <div class="container">

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
 <div class="mobile_continue">
<a href="<?php echo get_site_url(); ?>/shop-listing" class="button button-secondary" target="">
                    continue shopping<span class="hvr-forward"><svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 7.5L8.27586 14M16 7.5L8.27586 1M16 7.5L6.6955e-07 7.5" stroke="#F05E24" stroke-width="2"></path>
                        </svg>
                    </span>
                </a>
     </div>
    <div class="mobile_heading_cart">
        <h2>your cart</h2>
    </div>
    <div class="mobile_cart_info">
        <div class="items">2 Items</div>
        <div class="value">R550</div>
    </div>
    <!-- end: cart_nav in_page -->


            <h1>
            <?php echo get_the_title(); ?>
        </h1>
    </div>


    <div class="container" id="cart-page-empty" <?php if(WC()->cart->get_cart_contents_count() != 0){ ?> style="display: none;" <?php } ?>>
        <div class="cart_empty cart-page-empty">
            <h3>Your cart is empty</h3>
            <p>Browse available vouchers to get started.</p>
            <a href="<?php echo get_site_url(); ?>/shop-listing">buy vouchers</a>
        </div>
    </div>

    <?php if(WC()->cart->get_cart_contents_count() != 0){ ?>
        <div class="container cart-flex" id="cart-container">

        <div class="left-cart">
            <div class="delivery-options">
                <h2>Delivery Type</h2>
                <ul id="delivery_type">
                    <li class="active">Single Delivery</li>
                    <li>Split Delivery</li>
                </ul>
                <div class="single-delivery-content delivery-option active">
                    <div class="text">
                        Send all vouchers to a single recipient. <br>
                        How would you like to send it?
                    </div>
                    <div class="cart_radios">
                        <input type="radio" id="delivery_email" name="main_delivery_option" value="Email" checked />
                        <label for="delivery_email">Email</label>
                        <input type="radio" id="delivery_sms" name="main_delivery_option" value="SMS" />
                        <label for="delivery_sms">SMS</label>
                    </div>
                    <!-- start:  deliver-email -->
                    <div class="frm_forms deliver-email">
                        <div class=" frm_none_container frm_form_field">
                            <label for="" id="">Email Address</label>
                            <input type="email" value="" placeholder="Email Address">
                        </div>
                    </div>
                    <!-- end:  deliver-email -->
                    <!-- start:  deliver-num -->
                    <div class="frm_forms deliver-num" style="display: none">
                        <div class=" frm_none_container frm_form_field">
                            <label for="" id="">Cellphone Number</label>
                            <input type="text" value="" placeholder="Cellphone Number">
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

//                    var_dump(WC()->cart->cart_contents[$cart_item_key]['del_method']);
//                    var_dump(WC()->cart->cart_contents[$cart_item_key]['del_value']);
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
                            <div class="ca_info">Static html: 3 Month membership (R190)</div>
                            <div class="ca_holder_spinner_price">
                                <!--   <input type="number" value="<?php // echo $quantity; ?>" /> -->
                                <div class="spinner">
                                    <!-- start: number_spinner -->
                                    <div class="number_spinner">
                                        <span class="ns-btn" data-cart_key="<?php echo $cart_item_key; ?>" onclick="AdjustQuantity(this)">
                                            <a data-dir="dwn">
                                                <?php include (TEMPLATEPATH . '/images/vouchers/svg/spinner_minus.svg'); ?></a>
                                        </span>
                                        <input type="number" class="pl-ns-value" value="<?php echo $quantity; ?>">
                                        <span class="ns-btn" data-cart_key="<?php echo $cart_item_key; ?>" onclick="AdjustQuantity(this)">
                                            <a data-dir="up">
                                                <?php include (TEMPLATEPATH . '/images/vouchers/svg/spinner_plus.svg'); ?></a>
                                        </span>
                                    </div>
                                    <!-- end: number_spinner -->
                                </div>
                                <div class="price">
                                    <?php
                                    if($cp) {
                                        echo 'R'.$cp.'.00';
                                    } else {
                                        echo $price;
                                    } ?>
                                </div>
                            </div>
                            <div onclick="removeProd(this)" data-prod_id="<?php echo $product_id; ?>" data-cart_key="<?php echo $cart_item_key; ?>" class="remove-prod remove">
                            </div>
                        </div>
                    </div>
                    <!-- end: ca_holder -->
                    <!-- start: split-delivery-options -->
                    <div class="split-delivery-options" data-key="<?php echo $cart_item_key; ?>" style="display: none">
                        <input name="delsys<?php echo $cart_item_key; ?>" type="radio" id="delivery_email<?php echo $cart_item_key; ?>" name="split_delivery_option<?php echo $product_id; ?>" value="Email" checked />
                        <label for="delivery_email<?php echo $cart_item_key; ?>">Email</label>
                        <input name="delsys<?php echo $cart_item_key; ?>" type="radio" id="delivery_sms<?php echo $cart_item_key; ?>" name="split_delivery_option<?php echo $product_id; ?>" value="SMS" />
                        <label for="delivery_sms<?php echo $cart_item_key; ?>">SMS</label>
                        <br />
                        <br />
                        <!-- start:  deliver-email -->
                        <div class="frm_forms deliver-email">
                            <div class=" frm_none_container frm_form_field">
                                <label for="" id="">Email Address</label>
                                <input type="email" value="" placeholder="Email Address">
                            </div>
                        </div>
                        <!-- end:  deliver-email -->
                        <!-- start:  deliver-num -->
                        <div class="frm_forms deliver-num" style="display: none">
                            <div class=" frm_none_container frm_form_field">
                                <label for="" id="">Cellphone Number</label>
                                <input type="text" value="" placeholder="Cellphone Number">
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
        </div>
        <!-- start: right-cart-outer -->
        <div class="right-cart-outer">

   

            <!-- start:  shop-continue -->
            <div class="btn shop-continue flex" data-animatea="animated fadeInUp">
                <a href="<?php echo get_site_url(); ?>/shop-listing" class="button button-secondary" target="">
                    continue shopping<span class="hvr-forward"><svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 7.5L8.27586 14M16 7.5L8.27586 1M16 7.5L6.6955e-07 7.5" stroke="#F05E24" stroke-width="2"></path>
                        </svg>
                    </span>
                </a>
            </div>
            <!-- end:  shop-continue -->

            <!-- start: right-cart -->
            <div class="right-cart">
                <div class="order-summary">
                    <h3>Order Summary</h3>
                    <div class="summary-content">
                        <div class="summary-totals">
                            <div class="summary-total-sub">
                                <span>Subtotal</span>
                                <span class="woo-total"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
                            </div>
                            <div class="summary-total-discount">
                                <span>Discount</span>
                                <?php echo WC()->cart->get_discount_total(); ?>
                            </div>
                        </div>
                        <div class="sum-total"><span>Total: </span>
                            <span class="woo-total"><?php echo WC()->cart->get_total();  ?></span>
                        </div>
<!--                        <a id="process_cart" class="inactive" href="javascript:void(0);">Proceed to Payment</a>-->
                        <a id="process_cart" class="" href="javascript:void(0);">Proceed to Payment</a>
                    </div>
                </div>
            </div>
            <!-- end: right-cart -->
        </div>
        <!-- end: right-cart-outer -->
    </div>
    <?php } ?>
</div>
<script type="text/javascript">
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


    jQuery('#process_cart').on('click', function() {

        // 1. CHECK IF SPLIT OR SINGLE DELIVERY METHOD

        if (jQuery('#delivery_type .active').text() == 'Single Delivery') {

            var DeliveryType = 'Single';
            var DeliveryMethod = jQuery('input[name=main_delivery_option]:checked').val();

            if (DeliveryMethod == 'Email') {
                var DeliveryMethodValue = jQuery('.deliver-email input').val();
            } else {
                var DeliveryMethodValue = jQuery('.deliver-num input').val();
            }

        } else {
            var DeliveryType = 'Split';
        }

        // 2. IF SINGLE DELIVERY
        //     a.VALIDATE IF INPUT DATA IS VALID
        //     b.LOOP THROUGH CART ITEMS AND UPDATE DELIVERY OPTION META DATA BASED ON MAIN INPUTS
        //     c.LOOP THROUGH CART ITEMS AND UPDATE QUANTITIES IF THEY CHANGED


        if (DeliveryType == 'Single') {

            if(jQuery('input[name=main_delivery_option]:checked').val() == 'Email'){
                if(isEmail($('.deliver-email input').val()) == false){
                    $('.deliver-email input').addClass('invalid');
                    return false;
                } else {
                    $('.deliver-email input').removeClass('invalid');
                }

            }else{
                if($('.deliver-num input').val().length == 0){
                    $('.deliver-num input').addClass('invalid');
                    return false;
                }else {
                    $('.deliver-num input').removeClass('invalid');
                }
            }

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
                    window.location.href = '<?php echo get_site_url(); ?>/checkout';
                },
                error: function() {
                    // window.location.href = '/checkout';
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
                        valid = false;
                        return false;
                    } else {
                        valid = true;
                        jQuery(this).find('.deliver-email input').removeClass('invalid');
                    }

                    var cart_item_del_val = jQuery(this).find('.deliver-email input').val();

                } else {

                    if(jQuery(this).find('.deliver-num input').val().length == 0){
                        jQuery(this).find('.deliver-num input').addClass('invalid');
                        valid = false;
                        return false;
                    }else {
                        valid = true;
                        jQuery(this).find('.deliver-num input').removeClass('invalid');
                    }

                    var cart_item_del_val = jQuery(this).find('.deliver-num input').val();
                }


                cart_items.push(cart_item + '|' + cart_item_del_val + '|' + cart_item_del_sys);

            });

            if(valid == false){
                return false;
            }
            // console.log(valid);

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
                    window.location.href = '<?php echo get_site_url(); ?>/checkout';
                },
                error: function() {
                    console.log('nono')
                }

            });

        }


        // 3. AFTER ORDER DATA HAS BEEN UPDATE REDIRECT PAGE TO CHECKOUT


    });
});

const validateEmail = (email) => {
    return email.match(
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
};
</script>
<?php get_footer(); ?>