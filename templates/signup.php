<!-- <a href="#test-popup" class="open-popup-link">Show inline popup</a> -->
<div id="page-signup" class="page-signup mfp-hide">
	<div class="modal-nav">
		<div class="container">
			<div class="site-logo">
				<a href="<?php echo get_option('home'); ?>/"><?php include (TEMPLATEPATH . '/images/svg/logo-light.svg'); ?></a>
			</div>
			<div class="site-nav">
				<div class="burger flex signupbutton">
					<button class="hamburger signup hamburger--spin is-active" type="button">
						<span class="hamburger-box mfp-close" >
							<span class="burger-label mfp-close"></span>
							<span class="hamburger-inner mfp-close"></span>
						</span>
					</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-content">
		  <div class="container flex row">
			<div class="col left">
				<h6>SIGN UP</h6>
				<h2>Ready to get started? 
				Sign up your business.</h2>
				<h3>Don't be shy. Fill out the support form and we’ll get back to you. No spam, we promise.</h3>
			</div>
			<div class="col right">
				<div class="col-inner form-wrap">
					<h3>SIGN UP YOUR BUSINESS</h3>
					<?php echo do_shortcode('[formidable id=2]'); ?>
				</div>
			</div>
		</div>
	</div>
</div>