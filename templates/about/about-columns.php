<div class="data-bg" data-bg="theme-light"></div>
<div class="section about-columns">
	<?php
	if( have_rows('about_columns') ):
	    while ( have_rows('about_columns') ) : the_row(); 
	    	$theme = get_sub_field('column_style');
	    	$button = get_sub_field('link');
	    	?>
	    	<div class="col <?php echo $theme; ?>">
				<div class="col-inner fadeInUp slow">
					<h2><?php the_sub_field('title'); ?></h2>
					<?php the_sub_field('description'); ?>
					<div class="btn flex">
						<a href="<?php the_permalink(); ?>" class="button button-secondary" target="">Read More
							<span class="hvr-forward"><?php include (TEMPLATEPATH . '/images/svg/arrow-right.svg'); ?></span>
						</a>
					</div>
				</div>
			</div>
	    <?php endwhile;
	endif;
	?>
</div>
<div class="data-bg" data-bg="theme-light"></div>