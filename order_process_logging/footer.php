
<?php if (!is_page('sign-up-thank-you')) : ?>
	<?php include (TEMPLATEPATH . '/templates/footer.php'); ?>
	<?php include (TEMPLATEPATH . '/templates/menu.php'); ?>
	<?php include (TEMPLATEPATH . '/templates/signup.php'); ?>
	<?php //include (TEMPLATEPATH . '/templates/terms.php'); ?>
<?php endif; ?>


<div class="cart-popup">
    <div class="cart-holder">
        <div class="cart-header">
            <div class="cart-quantity">Cart(<span class="cart-quant"><?php echo WC()->cart->get_cart_contents_count(); ?></span>)</div>
            <button onclick="closeCart()" id="close-cart"><span>Close</span><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="0.707031" width="24" height="1" transform="rotate(45 0.707031 0)" fill="black" />
                <rect y="16.9707" width="24" height="1" transform="rotate(-45 0 16.9707)" fill="black" />
            </svg></button>
        </div>
        <div class="cart-validation"></div>

        <!-- start: cart_empty -->
        <div class="cart_empty" <?php if(WC()->cart->get_cart_contents_count() != 0){ ?> style="display: none;" <?php } ?>>
            <h3>Your cart is empty</h3>
            <p>Browse available vouchers to get started.</p>
            <a href="<?php echo get_site_url(); ?>/shop-listing">buy vouchers</a>
        </div>
        <!-- end: cart_empty -->



        <!-- start: voucherlimit -->
        <div class="voucherlimit"  <?php if(WC()->cart->get_cart_contents_count() > 5){ ?>style="display: block;"<?php } ?>>
            <h3>Voucher Limit Exceeded!</h3>
            <p>You can only purchase 5 content vouchers at a time. Remove vouchers from the cart to continue.</p>
        </div>
        <!-- end: voucherlimit -->


        <!-- start: digitaldelivery -->
        <div class="digitaldelivery" style="display: none;">
            <h3>Digital delivery</h3>
            <p>Vouchers are delivered via email or SMS after purchase.</p>
        </div>
        <!-- end: digitaldelivery -->

        <div class="cart-list">


            <?php
            global $woocommerce;



            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                $product = $cart_item['data'];
                $product_id = $cart_item['product_id'];
                $quantity = $cart_item['quantity'];
                $cp = $cart_item['custom_price'];
                $price = WC()->cart->get_product_price( $product );
                $subtotal = WC()->cart->get_product_subtotal( $product, $cart_item['quantity'] );
                $link = $product->get_permalink( $cart_item );
                $attributes = $product->get_attributes();
                $whatever_attribute = $product->get_attribute( 'whatever' );
                $whatever_attribute_tax = $product->get_attribute( 'pa_whatever' );
                $meta = wc_get_formatted_cart_item_data( $cart_item );
                $tags = get_the_terms( $product_id, 'product_tag' );
                $tag_logo = get_field('tag_logo', 'product_tag_'.$tags[0]->term_id);

                if(!$tag_logo){
                    $tag_logo = "https://place-hold.it/474x314?text=Image Pending&italic=true";
                }
                ?>
                <!-- start: cart-item -->
                <div class="cart-item">

                <!-- start: cart_item_top -->
                <div class="cart_item_top">

                    <img src="<?php echo $tag_logo; ?>"/>

                    <!-- start: cart_item_top_info -->
                    <div class="cart_item_top_info">
                        <h3><?php echo $tags[0]->name; ?></h3>
                        <span>statichetml: 3 Month membership (R190)</span>
                        <button class="editcartitem">
                            <span data-cart_key="<?php echo $cart_item_key; ?>" onclick="EditCartItem(this)">Edit</span>
                            <?php include (TEMPLATEPATH . '/images/vouchers/svg/icon_edit.svg'); ?>
                        </button>
                    </div>
                     <!-- start: cart_item_top_info -->

                    <div onclick="removeProd(this)" data-prod_id="<?php echo $product_id; ?>" data-cart_key="<?php echo $cart_item_key; ?>" class="remove-prod">
                    </div>

                </div>
                <!-- end: cart_item_top -->

                <!-- start: cart_item_lower -->
                <div class="cart_item_lower">
                   <!--  <input type="number" value="<?php // echo $quantity; ?>" /> -->

                <!-- start: number_spinner -->
                <div class="number_spinner">
                    <span class="ns-btn" data-cart_key="<?php echo $cart_item_key; ?>" onclick="AdjustQuantity(this)">
                    <a data-dir="dwn"><?php include (TEMPLATEPATH . '/images/vouchers/svg/spinner_minus.svg'); ?></a>
                    </span>

                    <input type="number" class="pl-ns-value" value="<?php echo $quantity; ?>"  min="0" max="10000">
                    <span class="ns-btn" data-cart_key="<?php echo $cart_item_key; ?>" onclick="AdjustQuantity(this)">
                    <a data-dir="up"><?php include (TEMPLATEPATH . '/images/vouchers/svg/spinner_plus.svg'); ?></a>
                    </span>
                </div>
                <!-- end: number_spinner -->


                    <span class="price">
                        <?php
                        if($cp) {
                            echo 'R'.$cp.'.00';
                        } else {
                            echo $price;
                        } ?>
                    </span>
                </div>
                <!-- end: cart_item_lower -->

                </div>
                <!-- end: cart-item -->
            <?php } ?>

        </div>


        <!-- start: cart-footer -->
        <div class="cart-footer"  <?php if(WC()->cart->get_cart_contents_count() == 0){ ?> style="display: none;" <?php } ?>>
            <div class="cart-totals">
                <div class="leftside">Total :</div>
                <span class="total-amount"><?php echo WC()->cart->get_total(); ?></span>
            </div>
            <?php if(WC()->cart->get_cart_contents_count() > 5){ ?>
                <div class="vlimit">Voucher limit exceeded</div>
            <?php } ?>

            <a <?php if(WC()->cart->get_cart_contents_count() > 5){ ?>href="javascript:void(0);"<?php } else { ?>href="<?php echo get_site_url(); ?>/checkout"<?php } ?>  class="button button-primary continue-checkout <?php if(WC()->cart->get_cart_contents_count() > 5){ ?>disable-checkout<?php } ?>">Continue to Checkout</a>
        </div>
        <!-- end: cart-footer -->


    </div>
</div>

<!--<div class="product-popups edit-cart-item" style="display: none;">-->
<!--    ssssss-->
<!--</div>-->

<script src="<?php bloginfo('stylesheet_directory'); ?>/dist/js/scripts.js?v=<?php echo time(); ?>"></script>

<?php if (is_product()) { ?>
<script>
	jQuery('input[type=number].wapf-input').on('focusout', function(){

		var invalue = jQuery(this).val();
		if (invalue.length < 10) {
			var incount = 10-invalue.length;
			var invaluen = invalue.padEnd(10, "0");
		}
		if (invalue.length > 10) {
			var invaluen = invalue.substring(0, 10);
		}
		if (invalue.length == 10) {
			var invaluen = invalue;
		}
		jQuery(this).val(invaluen);

	});
</script>
<?php } ?>

<?php if(isset($_GET['section'])){ ?>
<script>
$(window).on('load',function(){
	setTimeout( function(){
		var target_offset = $("#<?php echo $_GET['section']; ?>").offset();
		var target_top = target_offset.top-110;
		$('html, body').animate({scrollTop:target_top}, 100);	 
	}, 3500); // delay 300 ms
});
</script>
<?php } ?>


<div class="popi_bar">
<p>Kindly note that this website uses cookies in order to offer you the most optimal product offering and/or service. Please accept cookies to receive the best possible experience. <a href="https://www.pepkor.co.za/wp-content/uploads/2021/04/Privacy-Statement.pdf" target="_blank">Learn More</a></p>
<div class="btnbox">
	<a href="javascript:;" class="popibtn" target="">Accept</a>
</div>
</div>

<style>
.popi_bar {
    background: #0C0C0C;
    color: #FFFFFF;
    padding: 20px;
    position: fixed;
    z-index: 999;
    min-height: 75px;
    right: 0;
    bottom: 0;
    left: 0;
    display: flex;
    flex-direction: column;
    text-align: center;
    align-items: center;
}

@media (min-width: 768px) {
    .popi_bar {
        flex-direction: row;
        text-align: left;
    }
}

.popi_bar p {
    padding: 0 0px 0 0;
    margin-bottom: 0;
    align-self: center;
    font-size: 14px;
    line-height: 18px;
    color: #FFFFFF;
    width: calc(100% - 0px);
}

@media (min-width: 768px) {
    .popi_bar p {
        padding: 0 120px 0 0;
        font-size: 16px;
        line-height: 20px;
        width: calc(100% - 110px);
    }
}

.popi_bar p a {
    color: #FFFFFF;
    text-decoration: underline;
}

@media (min-width: 768px) {
    .btnbox {
        margin-top: 0px;
    }
}

.popibtn {
    padding: 10px 10px;
    width: 110px;
    font-size: 11px;
    color: #FFFFFF;
    line-height: 16px;
    margin: 0 auto;
    text-decoration: none;
    text-transform: uppercase;
    border: 1px solid #FF5F00;
    box-sizing: border-box;
    border-radius: 5px;
    letter-spacing: 2px;
    display: block;
    text-align: center;
    font-family: 'Circular Std';
    font-weight: 900;
    text-transform: uppercase;
}

@media (min-width: 768px) {
    .popibtn {
    	padding: 13px 10px;
        font-size: 13px;
    }
}

.btnbox {
	 margin-top: 10px;
}
 @media (min-width: 768px) {
	 .btnbox {
		 margin-top: 0;
	}
}
</style>
<script type="text/javascript">
jQuery(function() {
	var popicookie = readCookie('popi_bar');
	if (popicookie == 1) {
		jQuery('.popi_bar').hide();
	}
	jQuery('.popibtn').click( function() {
		jQuery('.popi_bar').fadeOut('fast');
		createCookie('popi_bar', 1 , 3);
	});
});
// create cookie
function createCookie(name, value, days) {
  var expires;
  if (days) {
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    expires = "; expires="+date.toGMTString();
  }
  else {
    expires = "";
  }
  document.cookie = name+"="+value+expires+"; path=/";
}
// read cookie
function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) === ' ') {
			c = c.substring(1, c.length);
		}
		if (c.indexOf(nameEQ) === 0) {
			return c.substring(nameEQ.length, c.length);
		}
	}
	return null;
}
</script>




<?php wp_footer(); ?>

<style>
	.redirectMessageStyle {
		color: #fff;
		text-align: center;
	}
</style>

<?php if( get_field('add_to_footer','options') ) {
	the_field('add_to_footer','options');
} ?>




<?php if ( isset($_GET['ninja']) && $_GET['ninja'] == 1 ) {

	//$testing = wc_get_order(21886);
	//print_r($testing);


	// $subject = 'Your 1ForYou Voucher';

	// $headers = array();
	// $headers[] = 'Content-Type: text/html; charset=UTF-8';
	// $headers[] = 'From: 1ForYou <no-reply@1foryou.com>';

	// wp_mail( 'gerhard@ninjasforhire.co.za', $subject, 'test message', $headers );

	// $teststring = '1515864481262655';

	// $teststring = chunk_split($teststring, 4, ' ');

	// echo $teststring;

	// echo 'done';

} ?>

</body>
</html>