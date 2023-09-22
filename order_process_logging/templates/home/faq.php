<div class="data-bg" data-bg="theme-white"></div>
<div class="section home-faq">
	<div class="container flex">

		<!-- start: left-side -->
		<div class="left-side">
			<div class="headings"><?php if( get_field('heading_thin') ): ?>
				<h2 class="thin"><?php the_field('heading_thin'); ?></h2> 
			<?php endif; ?>
			<?php if( get_field('heading_solid') ): ?>
				<h2 class="fat"><?php the_field('heading_solid'); ?></h2> 
			<?php endif; ?></div>
		</div>
		<!-- end: left-side -->

		<!-- start: right-side -->
		<div class="right-side">

		<?php $faqs = get_field('faq_selection'); 

				
		foreach ( $faqs as $faq ) {  ?>

			
			<div class="accordionItem close">
				<p class="accordionItemHeading flex"><?php echo get_the_title($faq->ID); ?></p>
				<div class="accordionItemContent">	
					<?php 
					$content = apply_filters('the_content',$faq->post_content);
					echo $content;
					?>
				</div>
			</div>
			<?php } ?>

			<a class="button button-primary" href="<?php the_field('see_more_link'); ?>?section=faqs"><?php the_field('page_link_text'); ?> </a>
 
		</div> 
		<!-- end: right-side -->

	</div>

</div>
<div class="data-bg" data-bg="theme-white"></div>