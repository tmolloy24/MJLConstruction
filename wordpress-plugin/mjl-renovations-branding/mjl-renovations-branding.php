<?php
/**
 * Plugin Name: MJL Renovations Branding
 * Description: Applies the approved MJL Renovations logo to pages created by the MJL Renovations Elementor Builder.
 * Version: 1.0.0
 * Author: MJL Construction
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'mjl-renovations-branding',
        plugin_dir_url( __FILE__ ) . 'assets/branding.css',
        [ 'mjl-renovations' ],
        '1.0.0'
    );
} );
