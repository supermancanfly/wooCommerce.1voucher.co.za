<div class="data-bg" data-bg="theme-white"></div>
<div class="section partner-network white">
	<div id="our_partners" class="jumplink"></div>
	<div class="container flex">
		<div class="row" >
			<div class="col left" animate>

				<h3>
					 <span class="vertical-reveal-outer">
						<span class="vertical-reveal-inner">
							<?php the_field('partner_network_title'); ?>
						</span>
					</span>
				</h3>
			</div>
			<div class="col right" animate>
				<span class="vertical-reveal-outer">
					<span class="vertical-reveal-inner">
						<p><?php the_field('partner_network_description'); ?></p>
					</span>
				</span>
				<?php
					$terms = get_terms( array(
					    'taxonomy' => 'network-cat',
					    'hide_empty' => true,
					));
				?>
				<div class="filter" animate>
					<form action="">
						<select id="partners">
							<option value="all" data-filter-heading="all">Filter By Category</option>
							<?php foreach ($terms as $term): ?>
								<option value="<?php echo $term->slug; ?>" data-filter-heading="<?php echo $term->slug; ?>"><?php echo $term->name; ?></option>
							<?php endforeach; ?>
						</select>
					</form>

				</div>
			</div>
		</div>
	</div>



	<div class="container">

		<div class="partners-main">
			
			<div class="partner-rows">
				<?php
					$args = array(
						'post_type' => 'network',
						'posts_per_page' => -1,
					);

					$the_query = new WP_Query( $args );
					if ( $the_query->have_posts() ) {
					    while ( $the_query->have_posts() ) : $the_query->the_post();
					    	$ipimage = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID(), 'image-partner') );
					    	$cat = get_the_terms( get_the_ID(), 'network-cat' );
					    	?>
					    	<div class="partner <?php echo $cat[0]->slug; ?>"><a href="<?php the_field('link'); ?>" target="_blank"><img src="<?php echo $ipimage; ?>" alt=""></a></div>
					    <?php endwhile;
					}
					wp_reset_postdata();
				?>
			</div>
			<div class="partner-navigation flex">
				<div class="partner-index-nav"></div>
				<div id="slider-arrows" class="slider-arrows">
					<button class="carousel-nav partner-carousel-prev caro-prev">
					</button>
					<button class="carousel-nav partner-carousel-next caro-next">
					</button>
				</div>
			</div>
		</div>

	</div>

</div>
<div class="data-bg" data-bg="theme-white"></div>