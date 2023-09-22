<div class="data-bg" data-bg="theme-white"></div>
<div class="section popular-faqs li ght">
	<div class="container flex">
		<div class="col left">
			<h2 class="thin">POPULAR</h2>
			<h2 class="fat">FAQs
				<div class="secondary-img">
					<img class="secondary-img-img" src="<?php bloginfo('stylesheet_directory'); ?>/images/svg/circlearrows.svg" alt="">
				</div>
			</h2>
			
		</div>
		<div class="col right">
			<?php 
			$posts = get_posts(array(
				'posts_per_page'	=> '10',
				'post_type'			=> 'support',
				'meta_key'		=> 'most_popular',
				'meta_value'	=> true
			));
			if( $posts ): ?>		
				<?php foreach( $posts as $post ): 
					setup_postdata( $post );
					?>
					<div class="accordionItem close">
						<p class="accordionItemHeading flex"><?php the_title(); ?></p>
						<div class="accordionItemContent">
							<?php the_content(); ?>
						</div>
					</div>
				<?php endforeach; ?>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
			<div class="btn flex">
				<a href="<?php echo get_option('home'); ?>/support#faqs" class="button button-primary">See more FAQs</a>
			</div>
		</div>
	</div>
</div>
<div class="data-bg" data-bg="theme-white"></div>