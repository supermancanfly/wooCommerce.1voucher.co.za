<div id="competition-terms" class="section terms-conditions-main light mfp-hide">
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
		<div class="container">
			<?php
			$post_object = get_field('competition_terms_button');
			if( $post_object ): 
				$post = $post_object;
				setup_postdata( $post ); 
				?>
					<h6>TERMS & CONDITIONS</h6>
					<h3 class="title"><?php the_title(); ?></h3>
					<?php the_content(); ?>

				<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
			<?php endif; ?>
		</div>
  	</div>
</div>
