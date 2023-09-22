<?php
get_header(); ?>
	<?php include (TEMPLATEPATH . '/templates/support/banner.php'); ?>
	<?php include (TEMPLATEPATH . '/templates/support/header.php'); ?>

	<?php 
		$terms = get_terms( array(
		    'taxonomy' => 'support-type',
		    'hide_empty' => false,
		    'parent' => 0,
		    'orderby' => 'term_id',
            'order' => 'ASC',
		));
	?>

	
	<div class="data-bg" data-bg="theme-light-bg"></div>
	<div id="faqs" class="section faqs-main light">
		<div class="container">
			
			<div class="tab-header">
				<ul class="nav nav-tabs flex" id="sel-option">
					<?php foreach ($terms as $term): ?>
						<li class="tab-nav-link" data-target="#support-<?php echo $term->slug; ?>">
				        	<a class="flex">
				        		<?php echo $term->name; ?>
				        	</a>
				        </li>	
					<?php endforeach; ?>
				</ul>


			</div>

			<div class="tab-body flex">

				<div class="tab-content">
					<?php foreach ($terms as $term): 

						$sub_terms = get_terms( array(
						    'taxonomy' => 'support-type',
						    'hide_empty' => false,
						    'parent' => $term->term_id
						));?>

						

						<div id="support-<?php echo $term->slug; ?>" class="support-tab-row row-<?php echo $term->term_id; ?>">
							<div class="page-left tab-left">
								<ul class="nav nav-tabs flex support-subs">
									<?php 
									$count_sub = 0;
									foreach ($sub_terms as $sub_term): 
										$count_sub++; ?>
										<li class="tab-nav-link" data-target="#support-<?php echo $sub_term->slug; ?>">
								        	<a class="flex">
								        		<span>0<?php echo $count_sub; ?></span>
								        		<?php echo $sub_term->name; ?>
								        	</a>
								        </li>	
									<?php endforeach; ?>
								</ul>
								<div class="support-type-mobile ae-dropdown">

									<div class="ae-select">
										<span class="ae-select-content"></span>
										<span class="arrow"><?php include (TEMPLATEPATH . '/images/svg/dropdown.svg'); ?></span>
									</div>

									<ul class="nav nav-tabs flex support-subs dropdown-menu ae-hide">
									
										<?php 
										$count_sub = 0;
										foreach ($sub_terms as $sub_term): 
											$count_sub++; ?>
											<li class="tab-nav-link" data-target="#support-<?php echo $sub_term->slug; ?>">
									        	<a class="flex">
									        		<span>0<?php echo $count_sub; ?>.</span> 
									        		<?php echo $sub_term->name; ?>
									        	</a>
									        </li>	
										<?php endforeach; ?>
										
									</ul>
								</div>
							</div>
							<div class="page-right tab-right">

								<?php foreach ($sub_terms as $sub_term): 
										$args = array(
										'post_type' => 'support',
										'posts_per_page' => -1,
										'tax_query' => array(
										    array(
										    'taxonomy' => 'support-type',
										    'field' => 'term_id',
										    'terms' => $sub_term->term_id
										     )
										  )
										);
										$the_query = new WP_Query( $args );
									?>
									<div id="support-<?php echo $sub_term->slug; ?>">
										<div class="support-caro tab-<?php echo $sub_term->slug; ?>">
											<?php 
											if ( $the_query->have_posts() ) {
											    while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
												<div class="accordionItem close">
													<p class="accordionItemHeading flex"><?php the_title(); ?></p>
													<div class="accordionItemContent">
														<?php the_content(); ?>
													</div>
												</div>
											    <?php endwhile;
											}
											wp_reset_postdata(); ?>
										</div>
										<div id="support-<?php echo $sub_term->slug; ?>" class="tab-pane"> 
								
											<div class="support-navigation flex">
												<div id="support-index" class="support-index-tab-<?php echo $sub_term->slug; ?> ">
													
												</div>
												<div id="support-arrow" class="support-arrow-tab-<?php echo $sub_term->slug; ?>">
													<button class="carousel-nav support-arrow-tab-<?php echo $sub_term->slug; ?>-prev caro-prev">
													</button>
													<button class="carousel-nav support-arrow-tab-<?php echo $sub_term->slug; ?>-next caro-next">
													</button>
													
												</div>
											</div>
										</div>
									</div>
									
								<?php endforeach; ?>
							</div>
							

							
						</div>
					<?php endforeach; ?>
				</div>	
			</div>
		</div>
	</div>
	<div class="data-bg" data-bg="theme-light-bg"></div>
		
		
<?php get_footer(); ?>