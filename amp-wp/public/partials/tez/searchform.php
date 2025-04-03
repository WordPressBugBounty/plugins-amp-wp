<?php
/**
 * The Template for Displaying Search Form
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/searchform.php.
 *
 * HOWEVER, on occasion AMP WP will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://help.ampwp.io/article-categories/developer-documentation/
 * @package Amp_WP/Templates
 * @version 1.0.0
 */

?>
<form role="search" method="get" class="search-form <?php echo ! get_search_query( false ) ? 'empty' : ''; ?>" action="<?php echo esc_url( amp_wp_site_url() ); ?>">
	<label for="s" class="search-label"><?php amp_wp_translation_echo( 'search_on_site' ); ?></label>
	<div class="search-input">
		<input type="search" name="s" value="<?php the_search_query(); ?>" placeholder="<?php amp_wp_translation_echo( 'search_input_placeholder' ); ?>" class="search-field" />
		<button type="submit" class="search-submit amp-btn"><?php amp_wp_translation_echo( 'search_button' ); ?></button>
	</div>
</form>
