<div class="data-bg" data-bg="theme-white"></div>
<div class="section about-services">
	<div class="card-group row">
		<?php 
		$args = array( 
			'post_type' => 'service', 
			'posts_per_page' => -1,
		);

		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) {
			$c = true;
		    while ( $the_query->have_posts() ) : $the_query->the_post();  ?>
		    	<div class="col col-6">
		    		<div <?php echo (($c = !$c)? ' class="card dark"':'class="card light"'); ?>>
			    		<div class="card-inner" animate>
			    			<div class="card-header animated flex">
			    				<h3 class="title">
			    					<span class="vertical-reveal-outer">
										<span class="vertical-reveal-inner">
											<?php the_title(); ?>

											 
										</span>
									</span>
								</h3>
			    			</div>

			    			<div class="card-body">
			    				<span class="vertical-reveal-outer">
									<span class="vertical-reveal-inner">
										<?php the_content(); ?>
									</span>
								</span>
							</div>

			    			<div class="btn flex">
			    				<span class="vertical-reveal-outer">
									<span class="vertical-reveal-inner">
										<a href="<?php the_permalink(); ?>" class="button button-secondary">
											Learn More
											<span class="hvr-forward"><?php include (TEMPLATEPATH . '/images/svg/arrow-right.svg'); ?></span>
										</a>
									</span>
								</span>
							</div>
			    		</div>
			    		<div class="btn about-service-mobile flex">
							<a href="<?php the_permalink(); ?>" class="button button-secondary">
								<?php the_title(); ?>
								<span class="hvr-forward"><?php include (TEMPLATEPATH . '/images/svg/round-right-hover.svg'); ?></span>
							</a>
						</div>
					</div>
		    	</div>
		    <?php endwhile;
		}
		wp_reset_postdata();
		?>
	</div>
</div>
<div class="data-bg" data-bg="theme-white"></div>