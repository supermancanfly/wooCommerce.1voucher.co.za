<?php
get_header(); ?>
<div class="data-bg" data-bg="theme-light-bg"></div>
	<div class="section theme-light error-page flex">
		<div class="container flex" animate>
			<h1>
				<span class="vertical-reveal-outer">
					<span class="vertical-reveal-inner">
					404
					</span>
				</span>
			</h1>
			<h2>
				<span class="vertical-reveal-outer">
					<span class="vertical-reveal-inner">
						PAGE NOT FOUND
					</span>
				</span>
			</h2>
			<h3>
				<span class="vertical-reveal-outer">
					<span class="vertical-reveal-inner">
						Oh no, something went wrong.
					</span>
				</span>
			</h3>
			<div class="btn flex">
				<span class="vertical-reveal-outer">
					<span class="vertical-reveal-inner">
						<a href="<?php echo get_option('home'); ?>" class="button button-secondary" target="">TAKE ME HOME
							<span class="hvr-forward"><?php include (TEMPLATEPATH . '/images/svg/arrow-right.svg'); ?></span>
						</a>
					</span>
				</span>
			</div>
		</div>
	</div>
<?php get_footer(); ?>