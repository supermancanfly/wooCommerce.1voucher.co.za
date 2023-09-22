<div class="data-bg" data-bg="theme-light"></div>
<div class="section page-banner service-banner foryou-banner da rk da rk-bg flex">
	<div class="container flex">
		<?php
		if( have_rows('social', 'options') ): ?>
			<div class="social horizontal light flex">
				<?php 
				while ( have_rows('social', 'options') ) : the_row(); ?>
					<a class="social social-icon" href="<?php echo get_sub_field('link'); ?>" target="_blank">
						<?php include (TEMPLATEPATH . '/images/svg/' .get_sub_field('icon').'.svg'); ?>
					</a>
		    	<?php endwhile; ?>
			</div>    
		<?php endif; ?>


		<div class="banner-main-wrapper flex">
			<div class="col banner-item-left" animate>
				<?php if (get_field('banner_title')): ?>
					<h2>
						<span class="vertical-reveal-outer">
							<span class="vertical-reveal-inner">
								<?php echo get_field('banner_title') ?>
							</span>
						</span>
					</h2>
				<?php endif; ?>

				<?php if (get_field('banner_sub_title')): ?>
					<h3>
						<span class="vertical-reveal-outer">
							<span class="vertical-reveal-inner">
								<?php echo get_field('banner_sub_title'); ?>
							</span>
						</span>
					</h3>
				<?php endif; ?>

				<?php
				if( have_rows('image_cta') ): ?>
					<div class="image-group flex">
						<?php 
						while ( have_rows('image_cta') ) : the_row(); ?>
							<a class="image" href="<?php echo get_sub_field('link'); ?>">
								<span class="vertical-reveal-outer">
									<span class="vertical-reveal-inner">
										<img src="<?php echo get_sub_field('image'); ?>" alt="">
									</span>
								</span>
							</a>
				    	<?php endwhile; ?>
					</div>    
				<?php endif; ?>
				
			</div>
			<div class="col banner-item-right">
				<?php if (get_field('banner_image')): ?>
					<img src="<?php echo get_field('banner_image'); ?>" alt="">
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<div class="data-bg" data-bg="theme-light"></div>