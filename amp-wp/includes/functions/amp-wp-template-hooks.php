<?php
/**
 * AMP WP Template Hooks
 *
 * General core functions available on both the front-end and admin.
 *
 * @category    Core
 * @package     Amp_WP/Functions
 * @version     1.0.0
 * @author      Pixelative <mohsin@pixelative.co>
 * @copyright   Copyright (c) 2018, Pixelative
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

/**
 * Callback: Custom Hook for Enqueue Scripts Action
 * action: amp_wp_template_head
 *
 * @version 1.0.0
 * @since   1.0.0
 */
function amp_wp_enqueue_scripts() {
	do_action( 'amp_wp_template_enqueue_scripts' );
}

// Header Hooks.
add_action( 'amp_wp_template_head_deferred', 'amp_wp_enqueue_scripts' );
add_action( 'amp_wp_template_head_deferred', 'amp_wp_print_styles' );
add_action( 'amp_wp_template_head_deferred', 'amp_wp_print_scripts' );
add_action( 'amp_wp_template_head_deferred', 'amp_wp_enqueue_boilerplate_style' );
add_action( 'amp_wp_template_head', 'wp_site_icon' );
add_action( 'amp_wp_template_head', 'amp_wp_print_rel_canonical' );
add_action( 'amp_wp_template_head', '_wp_render_title_tag' );
add_action( 'wp_head', 'amp_wp_print_rel_amphtml' );
add_filter( 'wp_nav_menu_args', 'amp_wp_theme_set_menu_walker', 9999 );
add_action( 'init', 'amp_wp_fix_customizer_statics', 3 );

add_action( 'after_setup_theme', 'amp_wp_compatibility_constants' );
