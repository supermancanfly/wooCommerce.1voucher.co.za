<div class="data-bg" data-bg="theme-light"></div>
<div class="section page-banner about-banner flex">
	<div class="container flex">
		<?php
		if( have_rows('social', 'options') ): ?>
			<div class="social horizontal dark flex">
				<?php 
				while ( have_rows('social', 'options') ) : the_row(); ?>
					<a class="social social-icon" href="<?php echo get_sub_field('link'); ?>" target="_blank">
						<?php include (TEMPLATEPATH . '/images/svg/' .get_sub_field('icon').'.svg'); ?>
					</a>
		    	<?php endwhile; ?>
			</div>    
		<?php endif; ?>


		<div class="banner-main-wrapper">
			<div class="banner-title">
				<h1><?php the_field('header_title'); ?></h1>
				<div class="img-outer"><img src="<?php the_field('header_image'); ?>" alt="<?php the_field('header_title'); ?>"></div>
 			</div>
			<div class="banner-columns row">
				<?php
				if( have_rows('header_columns') ):
				    while ( have_rows('header_columns') ) : the_row(); ?>
				        <div class="col col-6" animate>
							<h2>
								<span class="vertical-reveal-outer">
									<span class="vertical-reveal-inner">
										<?php the_sub_field('title'); ?>
									</span>
								</span>
							</h2>
							<span class="vertical-reveal-outer">
								<span class="vertical-reveal-inner">
									<?php the_sub_field('description'); ?>
								</span>
							</span>
						</div>
				    <?php endwhile;
				endif;
				?>
			</div>
		</div>
	</div>
</div>
<div class="data-bg" data-bg="theme-light"></div>