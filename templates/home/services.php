<div class="data-bg" data-bg="theme-white"></div>
<div class="section home-services">
	
	<div class="container">
		<h2 class="row-title thin" animate>
			<span class="vertical-reveal-outer">
				<span class="vertical-reveal-inner">
					Services
				</span>
			</span>
		</h2>

		<div class="card-group row" animate-secondary>
			<?php 
			$args = array( 
				'post_type' => 'service', 
				'posts_per_page' => -1,
			);

			$count = 0;
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) {
				$c = true;
			    while ( $the_query->have_posts() ) : $the_query->the_post(); 
			    	
			    	$count++; ?>

			    	<div <?php echo (($c = !$c)? ' class="col col-6 home-services-left"':'class="col col-6 home-services-right"'); ?>>

				    	<div class="card">
				    		<div class="card-inner">
				    			<div class="card-header flex">
				    				<h5 class="title"><?php the_title(); ?></h5>
				    				<div class="card-number">0<?php echo $count; ?></div>
				    			</div>

				    			<h3 class="card-title"><?php the_field('main_title'); ?></h3>

				    			<div class="card-body"><?php the_content(); ?></div>

				    			<?php if (get_field('outbound_link')): 
									$button = get_field('outbound_link'); ?>
									<div class="btn flex">
										<a href="<?php echo $button['url']; ?>" class="button button-secondary" target="<?php echo $button['target']; ?>"><?php echo $button['title']; ?>
											<span class="hvr-forward"><?php include (TEMPLATEPATH . '/images/svg/arrow-right.svg'); ?></span>
										</a>
									</div>
								<?php endif; ?>
								
				    		</div>
						</div>
					</div>
			    <?php endwhile;
			}
			wp_reset_postdata();
			?>
		</div>
	</div>
	<div class="page-break">
		<img src="<?php the_field('intro_break_banner'); ?>" loading="lazy" alt="">
	</div>

</div>
<div class="data-bg" data-bg="theme-white"></div>