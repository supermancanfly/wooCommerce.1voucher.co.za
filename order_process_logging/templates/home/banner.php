<?php
	global $nf;
	if( have_rows('banner') ):?>
		<div class="data-bg" data-bg="theme-light-bg"></div>
		<div class="section page-banner home-banner light flex">
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

				<div class="banner-main-wrapper">
					<div class="banner-main flex">
						<div class="col left">
							<div class="home-banner slider-for slick-slide">
								<?php
								while ( have_rows('banner') ) : the_row();
									$text_style = get_sub_field('text_style'); ?>
									<div class="left-slide">
										<?php if (get_sub_field('icon')): ?>
											<div class="icon">
												<span class="vertical-reveal-outer">
													<span class="vertical-reveal-inner">
														<img src="<?php echo get_sub_field('icon'); ?>" alt="">
													</span>
												</span>
											</div>
										<?php endif; ?>

										<?php if (get_sub_field('banner_type')): ?>
											<h6 class="orange">
												<span class="vertical-reveal-outer">
													<span class="vertical-reveal-inner">
														<?php echo get_sub_field('banner_type'); ?>
													</span>
												</span>
											</h6>
										<?php endif; ?>

										<?php if (get_sub_field('title')): ?>
											<h2 class="<?php echo $text_style; ?>">
												<span class="vertical-reveal-outer">
													<span class="vertical-reveal-inner">
														<?php echo get_sub_field('title') ?>
													</span>
												</span>
											</h2>
										<?php endif; ?>

										<?php if (get_sub_field('sub_title')): ?>
											<h3>
												<span class="vertical-reveal-outer">
													<span class="vertical-reveal-inner">
														<?php echo get_sub_field('sub_title'); ?>
													</span>
												</span>
											</h3>
										<?php endif; ?>

										<?php
										if( have_rows('image_group') ): ?>
											<div class="image-group flex">
												<?php
												while ( have_rows('image_group') ) : the_row(); ?>
													<a class="image" href="<?php echo get_sub_field('link'); ?>">
														<span class="vertical-reveal-outer">
															<span class="vertical-reveal-inner">
																<img src="<?php echo get_sub_field('image'); ?>" alt="">
															</span>
														</span>
													</a>
										    	<?php endwhile; ?>
											</div>
										<?php endif; ?>

										<?php if (get_sub_field('short_description')): ?>
											<span class="vertical-reveal-outer">
												<span class="vertical-reveal-inner">
													<p><?php echo get_sub_field('short_description'); ?></p>
												</span>
											</span>
										<?php endif; ?>

										<?php if (get_sub_field('button')):
											$button = get_sub_field('button'); ?>
											<div class="btn flex">
												<span class="vertical-reveal-outer">
													<span class="vertical-reveal-inner">
														<a href="<?php echo $button['url']; ?>" class="button button-primary" target="<?php echo $button['target']; ?>"><?php echo $button['title']; ?></a>
													</span>
												</span>
											</div>
										<?php endif; ?>
									</div>
								<?php endwhile; ?>
							</div>
						</div>

						<div class="col right">
							<div class="home-banner slider-nav slick-slide" style="visi bility: hidden">
								<?php
								while ( have_rows('banner') ) : the_row();

									$text_style = get_sub_field('text_style'); ?>
									<div class="right-slide">
										<?php if (get_sub_field('featured_image')): ?>
											<img src="<?php
												$featured_image = get_sub_field('featured_image');
												echo $nf->image($featured_image['sizes']['image-feature'],600,0,100);
												?>"  width="555"  loading="lazy"   height="555" alt="">
										<?php endif; ?>
									</div>
								<?php endwhile; ?>
							</div>
						</div>
						<div class="col home-slide-nav">
							<div class="banner-nav flex">
								<div class="col">
									<a href="#page-intro"  class="scroller hvr-icon-down infinite">
										<img class="hvr-icon" src="<?php bloginfo('stylesheet_directory'); ?>/images/scroll.png?var=12" alt="">
										Scroll
									</a>

								</div>
								<div class="col flex">
									<div id="slider-arrows" class="slider-arrows">
										<button class="carousel-nav home-carousel-prev">
											<?php include (TEMPLATEPATH . '/images/svg/pre.svg'); ?>
										</button>
										<button class="carousel-nav home-carousel-next">
											<?php include (TEMPLATEPATH . '/images/svg/next.svg'); ?>
										</button>
									</div>
									<div id="slider-dots" class="slider-dots">

									</div>
									<span class="slide-nav-index"></span>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

		</div>
		<div class="data-bg" data-bg="theme-light-bg"></div>
	<?php endif; ?>