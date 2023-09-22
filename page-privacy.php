<?php
/*
	Template Name: Privacy page
*/
get_header(); ?>
<div class="data-bg" data-bg="theme-light"></div>
<div class="section default-page privacy-page light-color">
	<div class="container">
		<?php if (have_posts()) { while (have_posts()) { the_post(); ?>
			<div class="page-title">
				<h2 class="fat">
					<?php the_field('fat_title'); ?>
				</h2>
				<h2 class="thin">
					<?php the_field('thin_title'); ?>
				</h2>
			</div>

			<div class="page-content">
				<?php the_content(); ?>
			</div>
		<?php } } ?>
	</div>
</div>
<div class="data-bg" data-bg="theme-light"></div>
<?php get_footer(); ?>