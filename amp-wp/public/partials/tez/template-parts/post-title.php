<?php
/**
 * The template for displaying post title in content loops
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/template-parts/post-title.php.
 *
 * HOWEVER, on occasion AMP WP will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://help.ampwp.io/article-categories/developer-documentation/
 *
 * @package Amp_WP/Templates
 * @version 1.0.0
 */

?>
<h2 class="post-title">
	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
</h2>
