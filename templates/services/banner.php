  <div class="data-bg" data-bg="theme-light"></div>  
<div class="section page-banner service-banner d ark l ight-bg flex">
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


				<?php if (get_field('banner_link')): 
					$button = get_field('banner_link'); ?>
					<div class="btn flex">
						<span class="vertical-reveal-outer">
							<span class="vertical-reveal-inner">
								<?php if (is_single('for-your-business')): ?>
									<a id="signup" class="open-popup-link button button-primary" href="#page-signup">Sign up your business</a>
									<?php else: ?>
									<a href="<?php echo $button['url']; ?>" class="button button-primary" target="<?php echo $button['target']; ?>"><?php echo $button['title']; ?></a>
								<?php endif; ?>
								
							</span>
						</span>
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