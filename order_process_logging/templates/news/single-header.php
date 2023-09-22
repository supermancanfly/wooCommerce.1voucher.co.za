<div class="data-bg" data-bg="theme-light-bg"></div>
<div class="section article-listing-header light">
	<div class="container row">
		<?php
		if( have_rows('social', 'options') ): ?>
			<div class="social horizontal dark flex">
				<?php 
				while ( have_rows('social', 'options') ) : the_row(); ?>
					<a class="social social-icon" href="<?php echo get_sub_field('link'); ?>">
						<?php include (TEMPLATEPATH . '/images/svg/' .get_sub_field('icon').'.svg'); ?>
					</a>
		    	<?php endwhile; ?>
			</div>    
		<?php endif; ?>
		<div class="banner-main-wrapper">
				
			<?php
			if( have_rows('sponsored_logos') ): ?>
				<div class="sponsored-wrapper">
				    <?php while ( have_rows('sponsored_logos') ) : the_row(); ?>
				        <div class="logo">
				        	<img src="<?php the_sub_field('logo'); ?>" alt="">
				        </div>
				    <?php endwhile; ?>
			    </div>
			<?php endif; ?>
				
			<h5>
				<?php echo $cat[0]->name ?> / 
				<?php if (get_field('competition_end_date')): ?>
					Closing: <?php the_field('competition_end_date'); ?>
				<?php else: ?>
					<?php echo get_the_date('d.m.y'); ?>
				<?php endif ?>
				
					
			</h5>
			<h2><?php the_title(); ?></h2>
		</div>
	</div>
</div>
<div class="data-bg" data-bg="theme-light"></div>