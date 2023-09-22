<?php get_header(); ?>	
	<?php if (have_posts()) { while (have_posts()) { the_post(); ?>
		
		<?php include (TEMPLATEPATH . '/templates/services/banner.php'); ?>

		<?php page_intro("secondary"); ?>

		<?php include (TEMPLATEPATH . '/templates/services/how-it-works.php'); ?>

		<?php include (TEMPLATEPATH . '/templates/services/business-portal.php'); ?>

		<?php include (TEMPLATEPATH . '/templates/one-voucher-partner-network.php'); ?>

		<?php include (TEMPLATEPATH . '/templates/services/outlets.php'); ?>
		
		<?php if (is_single('for-you')): ?>
			<?php include (TEMPLATEPATH . '/templates/services/popular-faqs.php'); ?>
		<?php endif; ?>
		
		
	<?php } } ?>	
<?php get_footer(); ?>