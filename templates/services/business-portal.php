<?php if(get_field('show_business_portal')): ?>
<div class="data-bg" data-bg="theme-light-bg"></div>
<div class="section business-portal light">
	<div class="container">
		<div class="row">
			<div class="col left">
				<?php if (get_field('bp_sub_title')): ?>
					<h6 data-animate="animated fadeInUp"><?php echo get_field('bp_sub_title'); ?></h6>
				<?php endif; ?>

				<?php if (get_field('bp_title')): ?>
					<h3 data-animate="animated fadeInUp"><?php echo get_field('bp_title'); ?></h3>
				<?php endif; ?>

				<?php if (get_field('bp_description')): ?>
					<span data-animate="animated fadeInUp"><?php echo get_field('bp_description'); ?></span>
				<?php endif; ?>

				<?php if (get_field('bp_link')): 
					$button = get_field('bp_link'); ?>
					<div class="btn flex">
						<a href="#page-signup" class="button button-secondary open-popup-link" target="<?php echo $button['target']; ?>"><?php echo $button['title']; ?>
							<span class="hvr-forward"><?php include (TEMPLATEPATH . '/images/svg/arrow-right.svg'); ?></span>
						</a>
					</div>
				<?php endif; ?>

			</div>
			<div class="col right" data-animate="animated fadeInUp">
				<?php if (get_field('bp_image')): ?>
					<img src="<?php echo get_field('bp_image'); ?>" alt="">
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<div class="data-bg" data-bg="theme-light-bg"></div>
<?php endif; ?>