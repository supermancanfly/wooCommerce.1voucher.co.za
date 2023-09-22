<div class="data-bg" data-bg="theme-light-bg"></div>
<div class="section news-competitions home">
	
	<div class="container">
		<div class="row-title" animate>
			<span class="vertical-reveal-outer">
				<span class="vertical-reveal-inner">
					<h2 class="thin">News &</h2>
					<h2>Competitions</h2>
				</span>
			</span>
		</div>

		<div class="news-posts card-group flex">
			<?php 
			global $nf;
			$args = array( 
				'post_type' => 'post', 
				'posts_per_page' => '2',
			);

			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) {
				$c = true;
				$post_no = 0;
			    while ( $the_query->have_posts() ) : $the_query->the_post(); 
			    	$post_no++;
			    	
			    	$image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); 
			    	$cat = get_the_category(); 

			    	?>
			    	<div class="news-row card-group home-news-<?php echo $post_no;?> card-<?php echo $post_no;?> flex">
							<a href="<?php the_permalink(); ?>" class="card">
					    		<div class="card-inner" animate>

					    			<div class="card-image">
					    				<span class="vertical-reveal-outer">
											<span class="vertical-reveal-inner">
						    				<!-- 	<img src="<?php // echo $nf->image($image,350,350); ?>" alt=""> -->
						    					<img src="<?php echo $image ?>" alt="">
						    				</span>
						    			</span>
					    			</div>
					    			<?php
										if( have_rows('sponsored_logos') ): ?>
											<div class="sponsored">
											    <?php while ( have_rows('sponsored_logos') ) : the_row(); ?>
											    	<span class="vertical-reveal-outer">
														<span class="vertical-reveal-inner">
												        	<img src="<?php the_sub_field('logo'); ?>" alt="">
												        </span>
												    </span>
											    <?php endwhile; ?>
										    </div>
										<?php endif; ?>


					    			<h5>
					    				<span class="vertical-reveal-outer">
											<span class="vertical-reveal-inner">
												<?php echo $cat[0]->name ?> / <?php echo get_the_date('d.m.y'); ?>
											</span>
										</span>
									</h5>
					    			<h3 class="title">
					    				<span class="vertical-reveal-outer">
											<span class="vertical-reveal-inner">
							    				<?php the_title(); ?>
							    			</span>
							    		</span>
							    	</h3>
					    			<div class="card-body">
					    				<span class="vertical-reveal-outer">
											<span class="vertical-reveal-inner">
							    				<?php the_excerpt(); ?>
							    			</span>
							    		</span>
					    			</div>
					    			<div class="btn flex">
					    				<span class="vertical-reveal-outer">
											<span class="vertical-reveal-inner">
												<div class="button button-secondary" target="">Read More
												<span class="hvr-forward"><?php include (TEMPLATEPATH . '/images/svg/arrow-right.svg'); ?></span>
												</div>
											</span>
										</span>
									</div>
					    		</div>
							</a>
						</div>
			    <?php endwhile;
			}
			wp_reset_postdata();
			?>
		</div>

		<div class="view-more">
			<div class="btn flex">
				<a href="<?php echo get_option('home'); ?>/news-and-competitions/" class="button button-primary" target="">ALL News & COMPETITIONS
				</a>
			</div>
		</div>
		
	</div>

</div>
<div class="data-bg" data-bg="theme-light-bg"></div>