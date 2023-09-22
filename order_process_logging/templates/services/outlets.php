<?php if(get_field('show_where_do_i_find_it')): ?>
<div class="data-bg" data-bg="theme-light"></div>
<div class="section outlets-section light">
	<div class="container outlet-container">
		<div class="outlet-header flex" animate>
			<h3>
				<span class="vertical-reveal-outer">
					<span class="vertical-reveal-inner">
						<?php the_field('wdifi_title'); ?>
					</span>
				</span>
			</h3>
			<span class="vertical-reveal-outer">
				<span class="vertical-reveal-inner">
					<p><?php the_field('wdifi_description'); ?></p>
				</span>
			</span>
		</div>
		<div class="outlets flex">
			<?php
				if( have_rows('outlets', 'options') ):
				    while ( have_rows('outlets', 'options') ) : the_row(); ?>
				        <div class="outlet" data-animate="animated fadeInUp">
				        	<img src="<?php the_sub_field('outlet'); ?>">
				        </div>
				    <?php endwhile;
				endif;
			?>
		</div>
	</div>
</div>
<div class="data-bg" data-bg="theme-light"></div>
<?php endif; ?>