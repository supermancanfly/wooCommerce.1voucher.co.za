<div class="data-bg" data-bg="theme-light"></div>
<div class="section instagram dark">

	<div class="container">
		<div class="row-title">
			<h2>
				<span>S</span>
				<span>S</span>
				<span>SOCIAL</span>
			</h2>
		</div>
		<div class="section-intro">
			<p>New partner launches, competitions, and 1ForYou love on our Facebook, Instagram, and Twitter.</p>
		</div>

		<div class="btn flex">
			<a href="https://www.instagram.com/1foryouza/" class="button button-secondary btn-inverted" target="blank">

				MORE ON INSTAGRAM
				<span class="hvr-forward"><?php include (TEMPLATEPATH . '/images/svg/arrow-right.svg'); ?></span>
			</a>
		</div>
	</div>

	<div class="ig-media-main container flex">
		<div class="arr-col">
			<div class="arrow">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/images/gradient-arrow-logo.png" alt="">
			</div>

		</div>
		<div class="media-col">

			<div id="igmedia" class="media-col">

			<?php echo do_shortcode("[instagram-feed showheader=false num=10   showbutton=false showfollow=false ]"); ?>

			</div>

			<div id="insta-arrow-nav" class="insta-nav">
				<button class="carousel-nav insta-carousel-prev caro-prev">
				</button>
				<button class="carousel-nav insta-carousel-next caro-next">
				</button>
			</div>
		</div>
	</div>
</div>
<div class="data-bg" data-bg="theme-light"></div>