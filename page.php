<?php get_header(); ?>

<div class="data-bg" data-bg="theme-light-bg"></div>

<div class="section default-page black">
<div class="singlepage">

	<?php if (have_posts()) { while (have_posts()) { the_post(); ?>
	<div class="post">

	 

		<div class="postcopy">
			<?php the_content(); ?>
		</div>

	</div>
	<?php } } ?>

</div>
</div>

<?php get_footer(); ?>