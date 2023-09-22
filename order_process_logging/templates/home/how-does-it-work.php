<?php global $nf; ?>
<div class="data-bg" data-bg="theme-white"></div>
<div class="section how-does-it-work home">
 <div id="how" class="jumplink"></div>
	<div class="container">
		<div class="row hdiw">
			<div class="col col-6 left add_circle">
				<?php if (get_field('how_does_it_work_title')): ?>
					<h2 class="hdiw"><?php echo get_field('how_does_it_work_title'); ?></h2>
				<?php endif; ?>
			</div>
			<div class="col col-6 right" animate>
				<?php
				$count = 0;
				if( have_rows('how_does_it_work_steps') ):
				    while ( have_rows('how_does_it_work_steps') ) : the_row();
				    	$count++; ?>
				        <div class="step">
				        	<h3>
				        		<span class="vertical-reveal-outer">
									<span class="vertical-reveal-inner">
				        				<span class="thin">0<?php echo $count; ?>.</span>
				        				<?php the_sub_field('title'); ?>
				        			</span>
				        		</span>

		        			</h3>
		        			<span class="vertical-reveal-outer" >
								<span class="vertical-reveal-inner">
						        	<p><?php the_sub_field('description'); ?></p>
						        </span>
						    </span>
				        </div>
				    <?php endwhile;
				endif;
				?>
			</div>
		</div>
	</div>
	
	<div class="container outlets-main" style="position: relative;">
		<div id="where" class="jumplink"></div>
	
		<div class="row">
			<div class="col left" animate>
				<span class="vertical-reveal-outer">
					<span class="vertical-reveal-inner">
						<h3><?php echo get_field('outlets_title'); ?></h3>
					</span>
				</span>
			</div>
			<div class="col right outlets flex"  >
				<?php
				if( have_rows('outlets', 'options') ):
				    while ( have_rows('outlets', 'options') ) : the_row(); ?>
				        <div class="outlet">
				        	<!-- <img width="200" height="120" loading="lazy" src="<?php // echo $nf->image(get_sub_field('outlet'), 205, ''); ?>"> -->
							<img width="200" height="120" loading="lazy" src="<?php echo get_sub_field('outlet'); ?>">

				        </div>
				    <?php endwhile;
				endif;
				?>
			</div>
		</div>

		<div class="lowerline"></div>
	</div>

</div>
<div class="data-bg" data-bg="theme-white"></div>