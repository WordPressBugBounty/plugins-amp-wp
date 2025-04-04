<?php
/**
 * The template to display the reviewers star rating in reviews
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/review-rating.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; } // Exit if accessed directly

global $comment;
$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
if ( $rating && get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
	$average = ( esc_attr( $rating ) / 5 ) * 100;
	amp_wp_add_inline_style( '.comment-' . intval( $comment->comment_ID ) . '-rating-stars .rating-stars-active{ width:' . $average . '% }' );
	?>
<div class="rating rating-stars <?php echo '.comment-' . intval( $comment->comment_ID ) . '-rating-stars'; ?>">
	<span class="rating-stars-active"></span>
</div>
	<?php
}
