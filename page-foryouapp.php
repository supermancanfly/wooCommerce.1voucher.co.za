<?php 
/*
	Template Name: For you app
*/
get_header(); ?>	
	<?php if (have_posts()) { while (have_posts()) { the_post(); ?>
		
		<?php include (TEMPLATEPATH . '/templates/for-you-app/header.php'); ?>
 
		<?php page_intro("secondary"); ?>
 
		<?php include (TEMPLATEPATH . '/templates/for-you-app/getting-started.php'); ?>
 
		<?php include (TEMPLATEPATH . '/templates/for-you-app/flash-topup.php'); ?>	
		
	<?php } } ?>	
<?php get_footer(); ?>