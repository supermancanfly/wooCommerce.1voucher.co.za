<?php get_header(); ?>
	<?php if (have_posts()) { while (have_posts()) { the_post(); 
		$cat = get_the_category(); 
		if (get_field('featured_banner_image')) {
			$image = get_field('featured_banner_image');
		} else {
			$image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
		}
		 ?>
		<?php include (TEMPLATEPATH . '/templates/news/single-header.php'); ?>

		<?php $post_format = get_field('post_format'); 
			switch ($post_format) {
				case 'featured_1':
					include (TEMPLATEPATH . '/templates/news/featured-banner-full.php');
					break;
				default:
					include (TEMPLATEPATH . '/templates/news/featured-banner-half.php');
					break;
			}
		?>
		<div class="data-bg" data-bg="theme-light-bg"></div>
		<div class="single-post content">
			<div class="container">
				<?php the_content(); ?>
				
				<?php if (get_field('competition_enter_button') || get_field('competition_terms_button')): ?>
					<div class="competition-links">

						<?php if (get_field('competition_enter_button')): 
							$btn1 = get_field('competition_enter_button'); ?>
							<div class="btn left flex">
								<a href="<?php echo $btn1['url']; ?>" class="button button-primary" target="<?php echo $btn1['target']; ?>"><?php echo $btn1['title']; ?>
								</a>
							</div>
						<?php endif; ?>

						 <?php if (get_field('competition_terms_button')): ?>
						 	
					 		<div class="btn flex">
								<a class="open-popup-link button button-secondary" href="#competition-terms">View Competition Terms and Conditions
									<span class="hvr-forward"><?php include (TEMPLATEPATH . '/images/svg/arrow-right.svg'); ?></span>
								</a>
							</div>
							
						<?php endif; ?>

					</div>
				<?php endif; ?>
				

				<div class="post-share">
					<div id="docLink"><?php the_permalink(); ?></div>
					<h6>Share</h6>
					<div class="shareblock flex">
						<a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" target="_blank">Facebook</a>
						<a href="https://twitter.com/share?url=<?php the_permalink(); ?>&amp;text=<?php the_title(); ?>" target="_blank">Twitter</a>
						<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>" target="_blank">Linkedin</a>
						<a href="mailto:?Subject=<?php the_title(); ?>&amp;Body=<?php the_permalink(); ?>">Email</a>
						<a id="link-copy" onclick="copyToClipboard('#docLink')">Copy Link <span><span class="icon"></span>Copied to clipboard</span></a>
						<!-- <a id="site-link" href="#!" onclick="copyClipBoard()">Copy Link</a> -->
					</div>
				</div>
			</div>
		</div>

		<?php 
		$next_post = get_previous_post();
		?>

		<?php if ($next_post) {
			$next_post_cat = get_the_category($next_post->ID);
			?>

			<div class="next-post-block">
				<div class="container">
					<h2>Next</h2>
					<a href="<?php echo get_the_permalink($next_post->ID); ?>" class="next-card">
						<h5><?php echo $next_post_cat[0]->name ?> / <?php echo get_the_date('d.m.y', $next_post->ID); ?></h5>
						<h3><?php echo get_the_title($next_post->ID); ?></h3>
						<p><?php echo get_the_excerpt($next_post->ID); ?></p>
						<div class="btn flex">
							<div class="button button-secondary" target="">Read More
								<span class="hvr-forward"><?php include (TEMPLATEPATH . '/images/svg/arrow-right.svg'); ?></span>
							</div>
						</div>
					</a>

				</div>
			</div>

			<?php

		}  else { ?>

			<div class="next-post-block">
				<div class="container">
					
				</div>
			</div>

		<?php }
	} 

} ?>
<?php include (TEMPLATEPATH . '/templates/news/single-terms.php'); ?>
<div class="data-bg" data-bg="theme-light"></div>
<?php get_footer(); ?>