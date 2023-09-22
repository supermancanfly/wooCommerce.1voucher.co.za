<div id="navigation" class="page-nav <?php if (is_page('shop-listing') || is_product_category() ) {echo 'theme-light-bg';} ?>">
	<div class="container flex">

		<div class="site-logo">
		<a href="<?php echo get_option('home'); ?>/"><?php include (TEMPLATEPATH . '/images/logo2022.svg'); ?></a>
		</div>

		<div class="site-logo-mobile">
		<a href="<?php echo get_option('home'); ?>/"><?php include (TEMPLATEPATH . '/images/vouchers/svg/mobile_logo.svg'); ?></a>
		</div>



		<div class="secondary-menu">

			<?php  //wp_nav_menu( array('menu' => 'Nav Menu Primary' )); ?>

			<?php if ( is_page('home') ) { ?>
				<!-- home menu -->
				<ul id="menu-nav-menu-primary">
					<li><a href="https://www.1voucher.co.za/where-to-buy" target="_blank">where to buy</a></li>
					<li><a href="https://www.1voucher.co.za/where-to-spend" target="_blank">where to spend</a></li>
				<!-- 	<li><a href="https://www.1voucher.co.za/" target="_blank">Partners</a></li> -->
					<li><a href="https://flash.co.za/app" target="_blank">DOWNLOAD THE FLASH APP</a></li>


					<!-- <li><a href="#where">where to buy</a></li>
					<li><a href="#how">How to use</a></li>
					<li><a href="#our_partners">Partners</a></li>
					<li><a href="<?php //echo get_option('home'); ?>/oneforyou-app/">Download the 1ForYou App</a></li> -->
				</ul>
			<?php } else {  ?>
				<!-- inner page menu -->
				<ul id="menu-nav-menu-primary">	

				<li><a href="https://www.1voucher.co.za/where-to-buy" target="_blank">where to buy</a></li>
					<li><a href="https://www.1voucher.co.za/where-to-spend" target="_blank">where to spend</a></li>
					<!-- <li><a href="https://www.1voucher.co.za/" target="_blank">Partners</a></li> -->
					<li><a href="https://flash.co.za/app" target="_blank">DOWNLOAD THE FLASH APP</a></li>			
					 <?php /* ?>
					<li><a href="<?php // bloginfo('url'); ?>/home?section=where">where to buy</a></li>
					<li><a href="<?php // bloginfo('url'); ?>/home?section=how">How to use</a></li>
					<li><a href="<?php // bloginfo('url'); ?>/home?section=our_partners">Partners</a></li>
					
					<li><a href="<?php bloginfo('url'); ?>/home#where">where to buy</a></li>
					<li><a href="<?php bloginfo('url'); ?>/home#how">How to use</a></li>
					<li><a href="<?php bloginfo('url'); ?>/home#our_partners">Partners</a></li>
					<li><a  href="<?php echo get_option('home'); ?>/oneforyou-app/">Download the 1ForYou App</a></li>
					 <?php */ ?>
				</ul>
			<?php } ?>

		</div>

		<!-- <div class="cta cta_download">
			<a class="button button-plain" href="<?php //echo get_option('home'); ?>/oneforyou-app/">
				Download the 1ForYou App
			</a>
		</div> -->

		<div class="cta cta_buynow">
			<a class="button button-primary" href="<?php echo get_option('home'); ?>/shop-listing/">Buy vouchers</a>
		</div>

  
		<div class="cta">
			<!-- <?php
			//	$bslug = get_post_field( 'post_name', get_post() );
				//if ($bslug == 'for-your-business') { ?>
			<a class="open-popup-link button button-primary active signup-cta" href="#page-signup">Sign Up</a>
			<?php // } ?> -->
		</div>

		<!-- start: menubutton 
		<div class="menubutton-burger burger flex">
			<a class="open-popup-link" href="#page-menu">
				<button class="hamburger menubutton hamburger--spin" type="button">
					<span class="hamburger-box">
						<span class="burger-label"></span>
						<span class="hamburger-inner"></span>
					</span>
				</button>
			</a>
		</div>
		  end: menubutton -->

		<?php if (is_page('shop-listing') || is_product_category() || is_product_tag() ) {  ?> <div class="cta cta_cart">
		<a href="javascript:void(0);" id="open-cart"><span>Cart</span><div class="cart_items"><?php echo WC()->cart->get_cart_contents_count(); ?></div></a>
		</div>
		<?php } ?>

	</div>
</div>
