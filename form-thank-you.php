<?php
/*
	Template Name: Form Thank You
*/
get_header(); ?>


	<div class="form-thankyou message-sent">
		<div class="modal-nav">
			<div class="container">
				<div class="site-logo">
					<a href="<?php echo get_option('home'); ?>/"><?php include (TEMPLATEPATH . '/images/svg/logo-light.svg'); ?></a>
				</div>
				<div class="site-nav">
					<div class="burger flex signupbutton">
						<a href="<?php echo wp_get_referer(); ?>">
							<button class="hamburger signup hamburger--spin is-active" type="button">
								<span class="hamburger-box mfp-close" >
									<span class="burger-label mfp-close"></span>
									<span class="hamburger-inner mfp-close"></span>
								</span>
							</button>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="page-body">
			<div class="container">
				<h6>Message Sent</h6>
				<h1>Thanks for<br>Getting in Touch!</h1>
				<h3>We’ll have a 1ForYou consultant get back to you shortly.</h3>
				<div class="btn flex">
					<!-- <a href="<?php // echo get_option('home'); ?>" class="button button-primary" target="">send another message</a> -->

					<a href="/service/for-your-business/" class="button button-primary" target="">send another message</a>
				</div>
			</div>
		</div>
	</div>
	
	
<?php get_footer(); ?>