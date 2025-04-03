<?php
/**
 * Single Post Title
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/single-post/title.php.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit; } // Exit if accessed directly.
the_title( '<h1 class="post-title">', '</h1>' );
