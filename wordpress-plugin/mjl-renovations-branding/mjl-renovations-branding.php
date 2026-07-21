<?php
/**
 * Plugin Name: MJL Renovations Branding
 * Description: Applies the approved transparent MJL Renovations logo to renovation pages and Elementor editor previews.
 * Version: 2.0.0
 * Author: MJL Construction
 */
if(!defined('ABSPATH'))exit;
add_action('wp_enqueue_scripts',function(){
 $url=plugin_dir_url(__FILE__).'assets/mjl-renovations-logo.png';
 wp_enqueue_style('mjl-renovations-branding',plugin_dir_url(__FILE__).'assets/branding.css',[],'2.0.0');
 wp_register_script('mjl-renovations-branding',false,[],'2.0.0',true);wp_enqueue_script('mjl-renovations-branding');
 wp_add_inline_script('mjl-renovations-branding','document.addEventListener("DOMContentLoaded",function(){document.querySelectorAll(".mjl-logo img,.mjl-footer-logo img,.mjl-wordmark img").forEach(function(i){i.src='.wp_json_encode($url).';i.removeAttribute("srcset");});});');
});