<div id="navigation" class="page-nav-cart">
	<div class="container flex">

	<div class="site-logo">
	<a href="<?php echo get_option('home'); ?>/"><?php include (TEMPLATEPATH . '/images/logo2022.svg'); ?></a>
	</div>

	<div class="site-logo-mobile">
	<a href="<?php echo get_option('home'); ?>/"><?php include (TEMPLATEPATH . '/images/vouchers/svg/mobile_logo.svg'); ?></a>
	</div>

	<!-- start: cart_nav -->
	<div class="cart_nav desktop">
	    <ul>
	        <li class="cart_del_circle"><div class="circle"><span>1</span></div></li>
	        <li class="cart_del_text">Cart & Delivery</li>
	        <li>
	            <?php include (TEMPLATEPATH . '/images/vouchers/svg/chevron_right.svg'); ?>
	        </li>
	        <li class="cart_pay_circle"><div class="circle"><span>2</span></div></li>
	        <li class="cart_pay_text">Payment</li>
	    </ul>
	    <a href="<?php echo get_site_url(); ?>/shop-listing" class="btn_exitcheckout">
	    	<span>exit checkout</span>
	        <?php include (TEMPLATEPATH . '/images/vouchers/svg/icon_close.svg'); ?>
	    </a>
	</div>
	<!-- end: cart_nav -->

	

 
	</div>
</div>


