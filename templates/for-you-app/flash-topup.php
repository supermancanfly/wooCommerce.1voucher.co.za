<div class="data-bg" data-bg="theme-light-bg"></div>
<div id="page-intro" class="section page-intro page-intro-foryou secondary image-right d ark">
	
	<div class="container">
		<div class="row">
			<div class="col col-6 left">
				<?php if (get_field('ftu_image')): ?>
					<div class="primary-img topup"><img src="<?php the_field('ftu_image'); ?>" alt=""></div>
				<?php endif; ?>
			</div>

			<div class="col col-6 right" animate>

				<?php if (get_field('ftu_image')): ?>
					<div class="icon"><img src="<?php the_field('ftu_logo'); ?>" alt=""></div>
				<?php endif; ?>

				<?php if (get_field('ftu_title')): ?>
					<h3>
						<span class="vertical-reveal-outer">
							<span class="vertical-reveal-inner">
								<?php the_field('ftu_title'); ?>
							</span>
						</span>
					</h3>
				<?php endif; ?>

				<?php if (get_field('ftu_description')): ?>
					<span class="vertical-reveal-outer">
						<span class="vertical-reveal-inner">
							<p><?php the_field('ftu_description'); ?></p>
						</span>
					</span>
				<?php endif; ?>

				<?php if (get_field('ftu_link')): 
					$button = get_field('ftu_link'); ?>
					<span class="vertical-reveal-outer">
						<span class="vertical-reveal-inner">
							<div class="btn flex" data-animatea="animated fadeInUp">
								<a href="<?php echo $button['url']; ?>" class="button button-primary" target="<?php echo $button['target']; ?>">
									<?php echo $button['title']; ?>
									</span>
								</a>
							</div>
						</span>
					</span>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="page-break">
		<img class="" src="<?php the_field('page_break'); ?>" alt="">
	</div>
	
</div>
<div class="data-bg" data-bg="theme-light-bg"></div>
 