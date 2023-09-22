<?php 
	add_action('wp_ajax_myfilter', 'misha_filter_function'); // wp_ajax_{ACTION HERE} 
	add_action('wp_ajax_nopriv_myfilter', 'misha_filter_function');
	 
	function misha_filter_function(){
		global $nf;
		// for taxonomies / categories
		if( isset( $_POST['categoryfilter'] ) && $_POST['categoryfilter'] == 'all' ) {
			$args = array(  
		        'post_type' => 'post',
		        'post_status' => 'publish',
		    );
		} else {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field' => 'id',
					'terms' => $_POST['categoryfilter']
				)
			);
		}
			
	 
		$query = new WP_Query( $args );
	 
		if( $query->have_posts() ) :?>
			<div class="posts-container">
			<?php $count = 0; 
			$post_no = 0;
			while( $query->have_posts() ): $query->the_post(); 
				$post_no++;
				$image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); 
		    	$cat = get_the_category(); ?>
				<div class="news-row card-group card-<?php echo $post_no;?> flex">
					<a href="<?php the_permalink(); ?>" class="card">
			    		<div class="card-inner" animate>

			    			<div class="card-image">
			    				
		    					<img src="<?php echo $nf->image($image,351,384); ?>" alt="">
				    				
			    			</div>
			    			<?php
								if( have_rows('sponsored_logos') ): ?>
									<div class="sponsored">
									    <?php while ( have_rows('sponsored_logos') ) : the_row(); ?>
									    	
								        	<img src="<?php the_sub_field('logo'); ?>" alt="">
										        
									    <?php endwhile; ?>
								    </div>
								<?php endif; ?>


			    			<h5>
			    				
								<?php echo $cat[0]->name ?> / <?php echo get_the_date('d.m.y'); ?>
									
							</h5>
			    			<h3 class="title">
			    				
			    				<?php the_title(); ?>
					    			
					    	</h3>
			    			<div class="card-body">
			    				
			    				<?php the_excerpt(); ?>
					    			
			    			</div>
			    			<div class="btn flex">
			    				
								<div class="button button-secondary" target="">Read More
								<span class="hvr-forward"><?php include (TEMPLATEPATH . '/images/svg/arrow-right.svg'); ?></span>
								</div>
									
							</div>
			    		</div>
					</a>
				</div>
				
				<?php endwhile; ?>
			</div>
			<?php endif;
	 
		die();
	}


?>