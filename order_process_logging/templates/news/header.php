<div class="data-bg" data-bg="theme-light-bg"></div>
<div class="section news-listing-header light">
	<div class="container row">
		<?php
		if( have_rows('social', 'options') ): ?>
			<div class="social horizontal dark flex">
				<?php 
				while ( have_rows('social', 'options') ) : the_row(); ?>
					<a class="social social-icon" href="<?php echo get_sub_field('link'); ?>" target="_blank">
						<?php include (TEMPLATEPATH . '/images/svg/' .get_sub_field('icon').'.svg'); ?>
					</a>
		    	<?php endwhile; ?>
			</div>    
		<?php endif; ?>
		<div class="banner-main-wrapper">
			<div class="col left" animate>
				<h2 class="fat">
					<span class="vertical-reveal-outer">
						<span class="vertical-reveal-inner">
							<?php the_field('news_fat_title', 'options'); ?>
						</span>
					</span>
				</h2>
				<h2 class="thin">
					<span class="vertical-reveal-outer">
						<span class="vertical-reveal-inner">
							<?php the_field('news_thin_title', 'options'); ?>
						</span>
					</span>
				</h2>
			</div>
			<div class="col right">
				<div class="filter">
					<form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="filter">
					<?php
						if( $terms = get_terms( array( 'taxonomy' => 'category', 'orderby' => 'name' ) ) ) :  ?>
							<select id="postfilter" name="categoryfilter">
								<option value="all">Filter By Category</option>
								<?php foreach ($terms as $cat): ?>
									<option value="<?php echo $cat->term_id; ?>"><?php echo $cat->name; ?></option>
								<?php endforeach; ?>
							</select>
						<?php endif;
					?>
					<input type="hidden" name="action" value="myfilter">
				</form>
				</div>
			</div>
		</div>
	</div>
</div>
