<?php
/*
	Template Name: Home page
*/
get_header();
$detect = new Mobile_Detect; ?>

	<?php if (have_posts()) { while (have_posts()) { the_post(); ?>
		<?php include (TEMPLATEPATH . '/templates/home/banner.php'); ?>

		<div class="homepage">
			<?php page_intro(); ?>
		</div>

		<?php include (TEMPLATEPATH . '/templates/home/services.php'); ?>
		
		<?php include (TEMPLATEPATH . '/templates/home/how-does-it-work.php'); ?>
		<?php
		//if (!$detect->isMobile() && !$detect->isTablet()) {
			// include (TEMPLATEPATH . '/templates/home/ticker.php');
		//}
		?>
		 
		<?php include (TEMPLATEPATH . '/templates/one-voucher-partner-network.php');?>
		<?php include (TEMPLATEPATH . '/templates/home/news-competitions.php'); ?>
		<?php include (TEMPLATEPATH . '/templates/services/popular-faqs.php'); ?>
		<?php //include (TEMPLATEPATH . '/templates/home/faq.php'); ?>

	<?php } } ?>

	<?php
		//if (!$detect->isMobile() && !$detect->isTablet()) {
		//	include (TEMPLATEPATH . '/templates/home/instagram.php');
		//}
	?>

	

<?php get_footer(); ?>