<div class="data-bg" data-bg="theme-white"></div>
<div class="section how-does-it-work services-hdiw da rk" data-bg="theme-light">
	<div class="container">
		<div class="row">
			<div class="col col-6 left">
				<?php if (get_field('hdiw_title')): ?>
					<h2 class=""><?php echo get_field('hdiw_title'); ?></h2>
				<?php endif; ?>
				<?php if (get_field('hdiw_sub_title')): ?>
					<h3 class=""><?php echo get_field('hdiw_sub_title'); ?></h3>
				<?php endif; ?>
				<div class="light-arr"></div>
			</div>
			<div class="col col-6 right" animate>
				<div class="steps">
					<?php
					$count = 0;
					if( have_rows('hdiw_steps') ):
					    while ( have_rows('hdiw_steps') ) : the_row(); 
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
			        			<span class="vertical-reveal-outer">
									<span class="vertical-reveal-inner">
							        	<p><?php the_sub_field('description'); ?></p>
							        </span>
							    </span>
					        </div>
					    <?php endwhile;
					endif;
					?>
				</div>

				<?php if (get_field('hdiw_button')): 
					$button = get_field('hdiw_button'); ?>
					<div class="btn flex">
						<?php if (is_single('for-your-business')): ?>
							<a id="signup" class="open-popup-link button button-primary" href="#page-signup">Sign up your business</a>
							<?php else: ?>
							<a href="<?php echo $button['url']; ?>" class="button button-primary" target="<?php echo $button['target']; ?>"><?php echo $button['title']; ?></a>
						<?php endif; ?>
						
					</div>


					
				<?php endif; ?>
				
			</div>
		</div>
	</div>
</div>
<div class="data-bg" data-bg="theme-white"></div>