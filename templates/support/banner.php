<div class="data-bg" data-bg="theme-light-bg"></div>
<div class="section page-banner support-banner">
		<div class="container flex">
		<?php
		if( have_rows('social', 'options') ): ?>
			<div class="social horizontal light flex">
				<?php 
				while ( have_rows('social', 'options') ) : the_row(); ?>
					<a class="social social-icon" href="<?php echo get_sub_field('link'); ?>" target="_blank">
						<?php include (TEMPLATEPATH . '/images/svg/' .get_sub_field('icon').'.svg'); ?>
					</a>
		    	<?php endwhile; ?>
			</div>    
		<?php endif; ?>


		<div class="banner-main-wrapper flex">
			<div class="col left flex">
				<?php 
					$validKeys = array(
						'form_submitted'
					);
					$data = $nf->clean_array($_GET, $validKeys);
				?>
				<?php if (isset($data['form_submitted']) && $data['form_submitted'] == '1'): ?>
					<h2>Thanks for Getting in Touch!</h2>
					<h3>We’ll have a 1ForYou consultant get back to you shortly.</h3>
				<?php else: ?>
					<h2><?php the_field('support_title', 'options'); ?></h2>
					<h3><?php the_field('support_sub_title', 'options'); ?></h3>
				<?php endif; ?>
					<div class="col-inner form-wrap mobile-form">
						<h3>HOW CAN WE HELP?</h3>
						<?php echo do_shortcode('[formidable id=3]'); ?>
					</div>
				

				<div class="contact flex">
					<div class="col tel">
						<ul class="tels">
							<?php
							if( have_rows('phone', 'options') ):
							    while ( have_rows('phone', 'options') ) : the_row(); ?>
							        <li><a href="tel:<?php the_sub_field('phone'); ?>"><?php the_sub_field('phone'); ?> <?php the_sub_field('carrier'); ?></a></li>
							    <?php endwhile;
							endif;
							?>
						</ul>
					</div>
					<div class="col email">
						<ul class="emails">
							<?php
							if( have_rows('emails', 'options') ):
							    while ( have_rows('emails', 'options') ) : the_row(); ?>
							        <li><a href="mailto:<?php the_sub_field('email'); ?>"><?php the_sub_field('email'); ?></a></li>
							    <?php endwhile;
							endif;
							?>
						</ul>
					</div>
				</div>

				<div class="header-footer">
					<p><?php the_field('support_footer_text', 'options'); ?></p>
					<?php if (get_field('support_footer_link', 'options')): 
						$btn2 = get_field('support_footer_link', 'options'); ?>
						<div class="btn flex">
							<a href="<?php echo $btn2['url']; ?>" class="button button-secondary" target="<?php echo $btn2['target']; ?>"><?php echo $btn2['title']; ?>
								<span class="hvr-forward"><?php include (TEMPLATEPATH . '/images/svg/arrow-right.svg'); ?></span>
							</a>
						</div>
					<?php endif; ?>
				</div>

			</div>
			<div class="col right">
				<div class="col-inner form-wrap">
					<h3>HOW CAN WE HELP?</h3>
					<?php echo do_shortcode('[formidable id=3]'); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="data-bg" data-bg="theme-light-bg"></div>