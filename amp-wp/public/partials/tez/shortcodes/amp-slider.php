<amp-carousel class="amp-slider" layout="responsive" type="slides" <?php amp_wp_hw_attr(); ?> autoplay>
	<?php
	while ( amp_wp_have_posts() ) {
		amp_wp_the_post();
		if ( has_post_thumbnail() ) :
			?>
		<div>
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
		</div>
			<?php
	endif; }
	?>
</amp-carousel>
