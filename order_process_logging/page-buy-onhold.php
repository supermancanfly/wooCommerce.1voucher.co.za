<?php
/*
	Template Name: Buy Vouchers On Hold
*/

get_header(); ?>

<?php if (have_posts()) { while (have_posts()) { the_post(); ?>

<div class="data-bg" data-bg="theme-light-bg"></div>
<div class="section default-page white-bg">
	<div class="container">
		<!-- start: onhold-outer-outer -->
		<div class="onhold-outer">
			<div class="inner">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/images/onholdperson.png" alt="">
				<h2>It's not you, it's us</h2>
				<div class="subheading">
					<strong>Please note that we have temporarily disabled the Buy Voucher function on our website. </strong>
				</div>
				<p>We know you haven’t had the best experience of late, so we are working to fix this as quickly as possible.</p>
				<p>We’ll be back soon! We apologise for the inconvenience.</p>
			</div>
			<div class="line"></div>
			<div class="logo-section">
				<strong>Please note that you can still purchase 1FORYOU vouchers at our partners </strong>
				<div class="logos"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/logos_set.png" alt=""></div>
			</div>
		</div>
		<!-- end: onhold-outer -->
	</div>

</div>
<div class="data-bg" data-bg="theme-light-bg"></div>

<?php } } ?>

<?php get_footer(); ?>