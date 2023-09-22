<div class="data-bg" data-bg="theme-dark"></div>
<div class="footer">
	<div class="container container-small">
		<div class="row-title">

			<?php if( get_field('footer_heading','options') ): ?>
				<h2>
					<a class="o pen-popup-link" href="<?php the_field('footer_heading_link','options'); ?> ">
					<?php the_field('footer_heading','options'); ?> 
					<div class="arr">
					<img src="<?php bloginfo('stylesheet_directory'); ?>/images/white-arrow-logo.png" loading="lazy" alt="">
					</div>
					</a>
				</h2>
			<?php endif; ?>

			<!--<h2>
			<a class="open-popup-link" href="#page-signup">
			Download the app
			<div class="arr">
			<img src="<?php // bloginfo('stylesheet_directory'); ?>/images/white-arrow-logo.png" loading="lazy" alt="">
			</div>
			</a>
			</h2>
			-->
		
		</div>

		<div class="footer-blocks flex">
			<div class="col hello">
				<h3>Say hello!</h3>
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
			<div class="col services">
				<h6>Services</h6>
				<?php wp_nav_menu( array('menu' => 'Nav Menu Primary' )); ?>
			</div>
			<div class="col footer-menu">
				<h6>Company</h6>
				<?php wp_nav_menu( array('menu' => 'footer-menu' )); ?>
			</div>
			<div class="col social">
				<h6>social</h6>
				<?php
				if( have_rows('social', 'options') ): ?>
					<ul class="social vertical flex">
						<?php 
						while ( have_rows('social', 'options') ) : the_row(); ?>
							<li style="order:<?php echo get_sub_field('footer_order'); ?>;">
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
	<div class="copy container flex">
		<hr>
		<div class="copy-logo"><a href="http://flash-group.com" target="_blank"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/svg/flash.svg" alt=""></a></div>
		<div class="copy-text">
			Part of the <a href="https://flash.co.za/overview/" target="_blank">Flash Group</a> | All rights reserved
		</div>
		<div class="copy-links flex">
			<a class="" href="https://www.1voucher.co.za/terms-conditions-copy">Terms & Conditions</a>
			<a href="https://www.pepkor.co.za/wp-content/uploads/2021/04/Privacy-Statement.pdf" target="_blank">Privacy Policy</a>
			<a href="https://www.1voucher.co.za/cookie-policy ">Cookie Policy</a>
		</div>
	</div>
</div>