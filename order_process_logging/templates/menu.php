<div id="page-menu" class="page-menu mfp-hide">
	<div class="modal-nav">
		<div class="container">
			<div class="site-logo">
				<a href="<?php echo get_option('home'); ?>/">
					<?php // include (TEMPLATEPATH . '/images/svg/logo-light.svg'); ?>
					<?php include (TEMPLATEPATH . '/images/vouchers/svg/mobile_logo.svg'); ?>	
					</a>
			</div>

			<div class="site-nav">
				<div class="cta">
				 	<a class="open-popup-link button button-primary" href="#page-signup">Sign Up</a> 
					<!-- 
					<a class="button button-primary" href="<?php //echo get_option('home'); ?>/buy-a-voucher/">Buy Voucher</a>
					-->
				</div>
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
			<div class="row">
				<div class="col nav-left">
					<div class="main-menu-primary"> 

						<div class="for-desktop">
						<?php wp_nav_menu( array('menu' => 'Main Menu Primary' )); ?>
						</div>

						<div class="for-mobile">
						<?php wp_nav_menu( array('menu' => 'Mobile Menu primary' )); ?>
						</div>

					</div>
				</div>
				<div class="col nav-right flex">
					<div class="main-menu-secondary">
						 
						<div class="for-desktop">
							<?php wp_nav_menu( array('menu' => 'Main Secondary Menu' )); ?>
						</div>

						<div class="for-mobile">
						<?php wp_nav_menu( array('menu' => 'Mobile Menu Secondary' )); ?>
						</div>

					</div>
					<div class="main-menu-social flex">
						<div class="col contact">
							<ul class="emails">
								<?php
								if( have_rows('emails', 'options') ):
								    while ( have_rows('emails', 'options') ) : the_row(); ?>
								        <li><a href="mailto:<?php the_sub_field('email'); ?>"><?php the_sub_field('email'); ?></a></li>
								    <?php endwhile;
								endif;
								?>
							</ul>
							<ul class="tels">
								<?php
								if( have_rows('phone', 'options') ):
								    while ( have_rows('phone', 'options') ) : the_row(); ?>
								        <li><a href="tel:<?php the_sub_field('phone'); ?>"><?php the_sub_field('phone'); ?> <?php the_sub_field('carrier'); ?></a></li>
								    <?php endwhile;
								endif;
								?>
							</ul>
						</div>
						<div class="social">
							<?php
							if( have_rows('social', 'options') ): ?>
								<ul class="social vertical">
									<?php
									while ( have_rows('social', 'options') ) : the_row(); ?>
										<li>
											<a class="social flex" href="<?php echo get_sub_field('link'); ?>" target="_blank">
												<?php echo get_sub_field('title'); ?>
												<?php include (TEMPLATEPATH . '/images/svg/social-arrow.svg'); ?>
											</a>
										</li>
							    	<?php endwhile; ?>
								</ul>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>