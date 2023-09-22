<?php get_header(); ?>

	<?php include (TEMPLATEPATH . '/templates/news/header.php'); ?>
	
	<div class="section news-competitions page-news-main light">
		<div class="container">
			<div id="response" class="news-posts">
			<?php if (have_posts()): ?>
				<div class="posts-container">
					<?php 
					$post_no = 0;
					while ( have_posts() ) : the_post();
						$post_no++;
						$image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); 
				    	$cat = get_the_category();
						?>

					
						<div class="news-row card-group card-<?php echo $post_no;?> flex">
							<a href="<?php the_permalink(); ?>" class="card">
					    		<div class="card-inner" animate>

					    			<div class="card-image">
					    				<span class="vertical-reveal-outer">
											<span class="vertical-reveal-inner">
						    				<!-- 	<img src="<?php // echo $nf->image($image,351,384); ?>" alt=""> -->
						    					<img src="<?php echo $image; ?>" alt="">
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
							    				<?php //the_excerpt(); ?>
												<div class="excerpt-desk">
													<?php echo $nf->shorter_content( '40', get_the_excerpt(), '...' ); ?>
												</div>
												<div class="excerpt-mobile">
													<?php echo $nf->shorter_content( '20', get_the_excerpt(), '...' ); ?>
												</div>
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
					
					<?php endwhile; ?>
				</div>

				<?php 
					if (  $wp_query->max_num_pages > 1 ) {?>
						<div class="view-more">
							<div class="btn flex">
								<a href="#" class="button button-primary misha_loadmore" target="">More Articles
								</a>
								<!-- <div class="misha_loadmore">Loadmore</div> -->
							</div>
						</div>

					<?php } ?>

			<?php endif; ?>
			</div>
			
			
		</div>
	</div>
	<div class="data-bg" data-bg="theme-light"></div>
<?php get_footer(); ?>