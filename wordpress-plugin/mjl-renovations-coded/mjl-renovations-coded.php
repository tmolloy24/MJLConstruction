<?php
/**
 * Plugin Name: MJL Renovations Coded Site
 * Description: A fully coded renovation division for MJL Construction. Creates renovation pages, custom templates, scoped styles and a portfolio post type without changing the existing outdoor Elementor pages.
 * Version: 1.0.0
 * Author: MJL Construction
 */

if (!defined('ABSPATH')) exit;

final class MJL_Renovations_Coded {
    const VERSION = '1.0.0';
    const META = '_mjl_reno_code_page';

    public function __construct() {
        register_activation_hook(__FILE__, [__CLASS__, 'activate']);
        add_action('init', [$this, 'register_project_type']);
        add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
        add_action('save_post_page', [$this, 'save_page_meta']);
        add_filter('template_include', [$this, 'template_include'], 99);
        add_action('wp_enqueue_scripts', [$this, 'enqueue']);
        add_filter('body_class', [$this, 'body_class']);
        add_action('admin_notices', [$this, 'admin_notice']);
    }

    public static function logo_data_uri() {
        return 'data:image/png;base64,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';
    }

    public static function pages() {
        return [
            'renovations' => [
                'title' => 'Renovations',
                'eyebrow' => 'MJL RENOVATIONS',
                'headline' => 'Renovations Designed Around the Way You Live',
                'intro' => 'Premium kitchens, bathrooms, basements, whole-home renovations and custom homes across Burlington, Oakville, Waterdown, Hamilton and surrounding communities.',
                'hero' => 'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&w=2200&q=88',
                'kind' => 'home',
            ],
            'kitchen-renovations' => [
                'title' => 'Kitchen Renovations',
                'eyebrow' => 'KITCHEN RENOVATIONS',
                'headline' => 'A Kitchen Built Around Real Life',
                'intro' => 'Thoughtful layouts, custom cabinetry, durable surfaces and complete project coordination—from first plan through final detail.',
                'hero' => 'https://images.unsplash.com/photo-1556912167-f556f1f39fdf?auto=format&fit=crop&w=2200&q=88',
                'kind' => 'service',
            ],
            'bathroom-renovations' => [
                'title' => 'Bathroom Renovations',
                'eyebrow' => 'BATHROOM RENOVATIONS',
                'headline' => 'Everyday Function. Considered Luxury.',
                'intro' => 'Bathrooms designed for comfort, storage and long-term performance, with the waterproofing and workmanship the finished space depends on.',
                'hero' => 'https://images.unsplash.com/photo-1620626011761-996317b8d101?auto=format&fit=crop&w=2200&q=88',
                'kind' => 'service',
            ],
            'basement-renovations' => [
                'title' => 'Basement Renovations',
                'eyebrow' => 'BASEMENT RENOVATIONS',
                'headline' => 'Turn Underused Space Into Valuable Living Space',
                'intro' => 'Comfortable lower levels for family, entertaining, work, guests, fitness or additional income.',
                'hero' => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=2200&q=88',
                'kind' => 'service',
            ],
            'whole-home-renovations' => [
                'title' => 'Whole Home Renovations',
                'eyebrow' => 'WHOLE HOME & FULL GUT RENOVATIONS',
                'headline' => 'Rebuild the Home You Love Into the Home You Need',
                'intro' => 'Integrated planning for major layout changes, complete modernization and full interior transformations.',
                'hero' => 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=2200&q=88',
                'kind' => 'service',
            ],
            'custom-home-building' => [
                'title' => 'Custom Home Building',
                'eyebrow' => 'CUSTOM HOME BUILDING',
                'headline' => 'Build Deliberately From the Ground Up',
                'intro' => 'A custom home built through disciplined planning, accountable project management and careful quality control.',
                'hero' => 'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?auto=format&fit=crop&w=2200&q=88',
                'kind' => 'service',
            ],
            'renovation-process' => [
                'title' => 'Our Renovation Process',
                'eyebrow' => 'OUR PROCESS',
                'headline' => 'A Clearer Path From Idea to Completion',
                'intro' => 'Major projects become manageable when decisions happen in the right order.',
                'hero' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=2200&q=88',
                'kind' => 'process',
            ],
            'renovation-portfolio' => [
                'title' => 'Renovation Portfolio',
                'eyebrow' => 'OUR WORK',
                'headline' => 'Real Projects. Real Craftsmanship.',
                'intro' => 'A growing collection of MJL kitchens, bathrooms, basements, whole-home renovations and custom builds.',
                'hero' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=2200&q=88',
                'kind' => 'portfolio',
            ],
            'about-mjl-renovations' => [
                'title' => 'About MJL Renovations',
                'eyebrow' => 'ABOUT MJL',
                'headline' => 'Quality Work Requires More Than Skilled Hands',
                'intro' => 'Planning, communication and accountability matter as much as the final craftsmanship.',
                'hero' => 'https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?auto=format&fit=crop&w=2200&q=88',
                'kind' => 'about',
            ],
            'renovation-contact' => [
                'title' => 'Start Your Renovation',
                'eyebrow' => 'CONTACT MJL',
                'headline' => 'Tell Us What You Are Planning',
                'intro' => 'Share the property, project type, timing and what you want to improve. We will contact you about the right next step.',
                'hero' => 'https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=2200&q=88',
                'kind' => 'contact',
            ],
        ];
    }

    public static function activate() {
        foreach (self::pages() as $slug => $data) {
            $page = get_page_by_path($slug);
            if (!$page) {
                $id = wp_insert_post([
                    'post_type' => 'page',
                    'post_status' => 'draft',
                    'post_title' => $data['title'],
                    'post_name' => $slug,
                    'post_content' => self::starter_content($data['kind']),
                ]);
            } else {
                $id = $page->ID;
            }
            if ($id && !is_wp_error($id)) {
                update_post_meta($id, self::META, '1');
                update_post_meta($id, '_mjl_reno_eyebrow', $data['eyebrow']);
                update_post_meta($id, '_mjl_reno_headline', $data['headline']);
                update_post_meta($id, '_mjl_reno_intro', $data['intro']);
                update_post_meta($id, '_mjl_reno_hero', $data['hero']);
                update_post_meta($id, '_mjl_reno_kind', $data['kind']);
                update_post_meta($id, '_yoast_wpseo_title', $data['title'] . ' | MJL Construction');
                update_post_meta($id, '_yoast_wpseo_metadesc', $data['intro']);
            }
        }
        flush_rewrite_rules();
    }

    private static function starter_content($kind) {
        if ($kind === 'about') return '<h2>Built on responsibility</h2><p>MJL Construction combines hands-on building experience with clear communication, detailed planning and accountable project management.</p>';
        if ($kind === 'contact') return '<h2>Start with the details</h2><p>Use the project form or contact MJL directly at 289-828-1933 and info@mjlconstruction.ca.</p>';
        return '<h2>A renovation should feel organized</h2><p>Every successful project begins with a clear understanding of the home, the desired outcome, the investment and the decisions required before construction begins.</p>';
    }

    public function register_project_type() {
        register_post_type('mjl_project', [
            'labels' => ['name' => 'MJL Projects', 'singular_name' => 'MJL Project', 'add_new_item' => 'Add New MJL Project'],
            'public' => true,
            'show_in_rest' => true,
            'menu_icon' => 'dashicons-admin-home',
            'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
            'has_archive' => false,
            'rewrite' => ['slug' => 'renovation-project'],
        ]);
    }

    public function add_meta_boxes() {
        add_meta_box('mjl-reno-page-settings', 'MJL Renovation Page Settings', [$this, 'render_meta_box'], 'page', 'normal', 'high');
    }

    public function render_meta_box($post) {
        if (get_post_meta($post->ID, self::META, true) !== '1') {
            echo '<p>This box is used only for pages created by the MJL Renovations Coded Site plugin.</p>';
            return;
        }
        wp_nonce_field('mjl_reno_save', 'mjl_reno_nonce');
        $fields = [
            '_mjl_reno_eyebrow' => 'Eyebrow',
            '_mjl_reno_headline' => 'Hero headline',
            '_mjl_reno_intro' => 'Hero introduction',
            '_mjl_reno_hero' => 'Hero image URL',
        ];
        foreach ($fields as $key => $label) {
            $value = get_post_meta($post->ID, $key, true);
            echo '<p><label style="display:block;font-weight:600;margin-bottom:6px">' . esc_html($label) . '</label>';
            if ($key === '_mjl_reno_intro') echo '<textarea style="width:100%" rows="3" name="' . esc_attr($key) . '">' . esc_textarea($value) . '</textarea>';
            else echo '<input style="width:100%" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '"></p>';
        }
        echo '<p><strong>Editing:</strong> Use the normal WordPress editor below for the main page copy. Use Featured Image on MJL Projects for portfolio cards.</p>';
    }

    public function save_page_meta($post_id) {
        if (!isset($_POST['mjl_reno_nonce']) || !wp_verify_nonce($_POST['mjl_reno_nonce'], 'mjl_reno_save')) return;
        if (!current_user_can('edit_post', $post_id) || wp_is_post_revision($post_id)) return;
        foreach (['_mjl_reno_eyebrow','_mjl_reno_headline','_mjl_reno_intro','_mjl_reno_hero'] as $field) {
            if (isset($_POST[$field])) update_post_meta($post_id, $field, sanitize_text_field(wp_unslash($_POST[$field])));
        }
    }

    public function is_managed() {
        return is_page() && get_post_meta(get_queried_object_id(), self::META, true) === '1';
    }

    public function template_include($template) {
        if ($this->is_managed()) return plugin_dir_path(__FILE__) . 'templates/page-renovations.php';
        return $template;
    }

    public function enqueue() {
        if (!$this->is_managed()) return;
        wp_enqueue_style('mjl-renovations-coded', plugin_dir_url(__FILE__) . 'assets/site.css', [], self::VERSION);
        wp_enqueue_script('mjl-renovations-coded', plugin_dir_url(__FILE__) . 'assets/site.js', [], self::VERSION, true);
    }

    public function body_class($classes) {
        if ($this->is_managed()) $classes[] = 'mjl-renovations-coded';
        return $classes;
    }

    public function admin_notice() {
        if (!current_user_can('manage_options')) return;
        if (isset($_GET['activate']) && $_GET['activate'] === 'true') {
            echo '<div class="notice notice-success is-dismissible"><p><strong>MJL Renovations Coded Site activated.</strong> Draft renovation pages were created. Review them before publishing.</p></div>';
        }
    }
}

new MJL_Renovations_Coded();
