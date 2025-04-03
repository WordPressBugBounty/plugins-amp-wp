<?php
global $post;
amp_wp_enqueue_block_style( 'listing' );
amp_wp_enqueue_block_style( 'listing-grid' );
?>
<div class="posts-listing posts-listing-grid product-archive clearfix">
	<?php
	while ( amp_wp_have_posts() ) {
		amp_wp_the_post();
		$product = wc_get_product( get_the_ID() );
		?>
	<article <?php amp_wp_post_classes( array( 'listing-item', 'listing-grid-item' ) ); ?>>
		<div class="listing-grid-item-inner">
			<?php if ( $product->is_on_sale() ) : ?>
				<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . amp_wp_translation_get( 'product-sale' ) . '</span>', $post, $product ); ?>
			<?php endif; ?>

			<?php if ( has_post_thumbnail() ) { ?>
			<div class="post-thumbnail">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php amp_wp_the_post_thumbnail( 'amp-wp-normal' ); ?></a>
			</div>
			<?php } else { ?>
			<div class="post-thumbnail">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><img src="<?php echo esc_url( AMP_WP_DIR_URL . 'public/images/no-image-option-1.jpg' ); ?>" alt="<?php _e( 'No Image', 'amp-wp' ); ?>" /></a>
			</div>
			<?php } ?>

			<h3 class="post-title">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			</h3>

			<?php if ( $average = $product->get_average_rating() ) { ?>
			<div class="woocommerce-product-rating">
				<?php
				$average = ( $average / 5 ) * 100;
				amp_wp_add_inline_style( '.rating-stars-' . get_the_ID() . ' .rating-stars-active{width:' . $average . '%}' );
				?>
				<div class="rating rating-stars rating-stars-<?php the_ID(); ?>">
					<span class="rating-stars-active"></span>
				</div>
			</div>
			<?php } ?>

			<?php if ( $price_html = $product->get_price_html() ) : ?>
			<div class="woocommerce-price"><?php echo $price_html; ?></div>
			<?php endif; ?>

			<a href="<?php the_permalink(); ?>" class="amp-btn alt button-view-product"><?php amp_wp_translation_echo( 'product-view' ); ?></a>

			<?php
			$args = array();
			echo apply_filters(
				'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
				sprintf(
					'<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
					esc_url( $product->add_to_cart_url() ),
					esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
					esc_attr( isset( $args['class'] ) ? $args['class'] : 'amp-btn' ),
					isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
					esc_html( $product->add_to_cart_text() )
				),
				$product,
				$args
			);
			?>
		</div>
	</article>
	<?php } ?>
</div>
