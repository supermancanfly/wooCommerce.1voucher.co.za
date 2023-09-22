<div class="data-bg" data-bg="theme-white"></div>
<div class="section outlets-section foryouapp white-color">
	<div class="container outlet-container">
		<div class="outlet-header flex" animate>
			<h3>
				<span class="vertical-reveal-outer">
					<span class="vertical-reveal-inner">
						<?php the_field('getting_started_title'); ?>
					</span>
				</span>
			</h3>
			<span class="vertical-reveal-outer">
				<span class="vertical-reveal-inner">
					<p><?php the_field('getting_started_description'); ?></p>
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