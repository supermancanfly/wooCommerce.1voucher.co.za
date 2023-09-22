<?php
/*
	Template Name: About page
*/
get_header(); ?>

	<?php if (have_posts()) { while (have_posts()) { the_post(); ?>
		<?php include (TEMPLATEPATH . '/templates/about/banner.php'); ?>
 
		<?php page_intro(); ?>
 
		<?php include (TEMPLATEPATH . '/templates/about/about-services.php'); ?>
	<?php } } ?>
	
<?php get_footer(); ?>