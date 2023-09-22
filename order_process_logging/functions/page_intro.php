<?php 

// Adding secondary as an arg to this function will output the second layout with smaller text and no indentation.
// See Service pages for an example
function page_intro($style="") {
	global $post;
    $post_slug = $post->post_name;

	$banner_style = get_field('intro_banner_style');
	if (get_field('intro_banner_background')) {
		$banner_bg = 'style="background-image:url(' . get_field('intro_banner_background') .');"';
	} else {
		$banner_bg = "";
	}
	
	$image_align = get_field('intro_image_position');

	$row_class = "";
	$row_class .= $banner_style;
	$row_class .= " image-".$image_align;
	$row_class .= " ".$style;
	$row_class .= " ".$post_slug;

?>
<div class="data-bg" data-bg="theme-<?php echo $banner_style; ?>"></div>
<div id="page-intro" class="section page-intro <?php echo $row_class ?>" <?php echo $banner_bg ?>>
	
	<div class="container">
		<div class="row">
			<div class="col col-6 left">
				<?php if (get_field('intro_secondary_image')): ?>
					<div class="secondary-img"><img class="secondary-img-img" src="<?php the_field('intro_secondary_image'); ?>" alt=""></div>
				<?php endif; ?>

				<?php if (get_field('intro_primary_image')): ?>
					<div class="primary-img"><img src="<?php the_field('intro_primary_image'); ?>" alt=""></div>
				<?php endif; ?>

				<?php if (get_field('intro_mobile_image')): ?>
					<div class="mobile-img"><img src="<?php the_field('intro_mobile_image'); ?>" alt=""></div>
				<?php endif; ?>
			</div>

			<div class="col col-6 right" animate>
				<?php if (get_field('intro_title_style_1')): ?>
					<h2 class="thin">
						<span class="vertical-reveal-outer">
							<span class="vertical-reveal-inner">
								<?php the_field('intro_title_style_1'); ?>	
							</span>
						</span>
					</h2>
				<?php endif; ?>
				<?php if (get_field('intro_title_style_2')): ?>
					<h2 class="fat">
						<span class="vertical-reveal-outer">
							<span class="vertical-reveal-inner">
								<?php the_field('intro_title_style_2'); ?>
							</span>
						</span>
					</h2>
				<?php endif; ?>

				<?php if (get_field('intro_sub_title')): ?>
					<h3>
						<span class="vertical-reveal-outer">
							<span class="vertical-reveal-inner">
								<?php the_field('intro_sub_title'); ?>
							</span>
						</span>
					</h3>
				<?php endif; ?>

				<?php if (get_field('intro_description')): ?>
					<span class="vertical-reveal-outer">
						<span class="vertical-reveal-inner">
							<?php the_field('intro_description'); ?>
						</span>
					</span>
				<?php endif; ?>

				<?php if (get_field('intro_button')): 
					$button = get_field('intro_button'); ?>
					<span class="vertical-reveal-outer">
						<span class="vertical-reveal-inner">
							<div class="btn flex" data-animatea="animated fadeInUp">
								<a href="<?php echo $button['url']; ?>" class="button button-secondary" target="<?php echo $button['target']; ?>">
									<?php echo $button['title']; ?>
									<span class="hvr-forward"><?php include (TEMPLATEPATH . '/images/svg/arrow-right.svg'); ?>
									</span>
								</a>
							</div>
						</span>
					</span>
				<?php endif; ?>
			</div>
		</div>
	</div>
	
</div>
<div class="data-bg" data-bg="theme-<?php echo $banner_style; ?>"></div>
<?php } ?>