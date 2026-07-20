<?php
/**
 * Plugin Name: MJL Renovations Elementor Builder
 * Description: Creates a complete premium renovation page set for MJL Construction using Elementor-compatible page data.
 * Version: 1.0.0
 * Author: MJL Construction
 */

if ( ! defined( 'ABSPATH' ) ) exit;

final class MJL_Renovations_Builder {
    const VERSION = '1.0.0';
    const OPTION  = 'mjl_renovations_builder_results';

    public function __construct() {
        add_action( 'admin_menu', [ $this, 'menu' ] );
        add_action( 'admin_post_mjl_build_renovation_pages', [ $this, 'build' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'assets' ] );
        add_shortcode( 'mjl_renovation_form', [ $this, 'form_shortcode' ] );
    }

    public function assets() {
        wp_enqueue_style( 'mjl-renovations', plugin_dir_url( __FILE__ ) . 'assets/frontend.css', [], self::VERSION );
        wp_enqueue_script( 'mjl-renovations', plugin_dir_url( __FILE__ ) . 'assets/frontend.js', [], self::VERSION, true );
    }

    public function menu() {
        add_management_page( 'MJL Renovations Builder', 'MJL Renovations Builder', 'manage_options', 'mjl-renovations-builder', [ $this, 'screen' ] );
    }

    public function screen() {
        if ( ! current_user_can( 'manage_options' ) ) return;
        $results = get_option( self::OPTION, [] );
        ?>
        <div class="wrap">
            <h1>MJL Renovations Elementor Builder</h1>
            <p>This creates or refreshes the renovation pages listed below. It will never overwrite an existing page unless that page was previously created by this plugin.</p>
            <p><strong>Elementor must be active.</strong> The pages use the Elementor Canvas template so your current Astra header does not interfere while you review them.</p>
            <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                <input type="hidden" name="action" value="mjl_build_renovation_pages">
                <?php wp_nonce_field( 'mjl_build_renovation_pages' ); ?>
                <?php submit_button( 'Build or Refresh Renovation Pages' ); ?>
            </form>
            <?php if ( $results ) : ?>
                <h2>Last build</h2>
                <ul>
                    <?php foreach ( $results as $result ) : ?>
                        <li><?php echo esc_html( $result ); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <h2>Pages created</h2>
            <p>Renovations, Kitchen Renovations, Bathroom Renovations, Basement Renovations, Whole Home Renovations, Custom Home Building, Our Process, Portfolio, Financing, About MJL Renovations, Reviews and Contact.</p>
        </div>
        <?php
    }

    public function build() {
        if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Insufficient permissions.' );
        check_admin_referer( 'mjl_build_renovation_pages' );

        if ( ! did_action( 'elementor/loaded' ) ) {
            wp_die( 'Elementor is not active. Activate Elementor, then run the builder again.' );
        }

        $results = [];
        foreach ( $this->pages() as $slug => $page ) {
            $existing = get_page_by_path( $slug, OBJECT, 'page' );
            if ( $existing && '1' !== get_post_meta( $existing->ID, '_mjl_builder_managed', true ) ) {
                $results[] = "Skipped {$page['title']} because an unmanaged page already uses /{$slug}/.";
                continue;
            }

            $postarr = [
                'ID'           => $existing ? $existing->ID : 0,
                'post_title'   => $page['title'],
                'post_name'    => $slug,
                'post_type'    => 'page',
                'post_status'  => 'draft',
                'post_content' => '',
            ];
            $post_id = wp_insert_post( wp_slash( $postarr ), true );
            if ( is_wp_error( $post_id ) ) {
                $results[] = "Failed {$page['title']}: " . $post_id->get_error_message();
                continue;
            }

            $html = $this->render_page( $page );
            $data = [ [
                'id'       => substr( md5( $slug . '-container' ), 0, 8 ),
                'elType'   => 'container',
                'isInner'  => false,
                'settings' => [
                    'content_width' => 'full',
                    'width'         => [ 'unit' => '%', 'size' => 100, 'sizes' => [] ],
                    'padding'       => [ 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true ],
                    'html_tag'      => 'main',
                ],
                'elements' => [ [
                    'id'         => substr( md5( $slug . '-html' ), 0, 8 ),
                    'elType'     => 'widget',
                    'widgetType' => 'html',
                    'isInner'    => false,
                    'settings'   => [ 'html' => $html ],
                    'elements'   => [],
                ] ],
            ] ];

            update_post_meta( $post_id, '_elementor_edit_mode', 'builder' );
            update_post_meta( $post_id, '_elementor_template_type', 'wp-page' );
            update_post_meta( $post_id, '_elementor_version', defined( 'ELEMENTOR_VERSION' ) ? ELEMENTOR_VERSION : '3.34.2' );
            update_post_meta( $post_id, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
            update_post_meta( $post_id, '_elementor_page_settings', [ 'hide_title' => 'yes' ] );
            update_post_meta( $post_id, '_wp_page_template', 'elementor_canvas' );
            update_post_meta( $post_id, '_mjl_builder_managed', '1' );
            update_post_meta( $post_id, '_yoast_wpseo_title', $page['seo_title'] );
            update_post_meta( $post_id, '_yoast_wpseo_metadesc', $page['meta'] );
            $results[] = "Built {$page['title']} as a draft: " . get_edit_post_link( $post_id, '' );
        }

        update_option( self::OPTION, $results );
        wp_safe_redirect( admin_url( 'tools.php?page=mjl-renovations-builder' ) );
        exit;
    }

    private function pages() {
        return [
            'renovations' => [
                'title' => 'Home Renovations',
                'eyebrow' => 'MJL RENOVATIONS',
                'headline' => 'Remarkable Homes Start With Better Planning',
                'intro' => 'Premium kitchens, bathrooms, basements, full-home renovations and custom homes delivered with disciplined project management and craftsmanship that lasts.',
                'image' => 'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&w=2000&q=85',
                'services' => true,
                'sections' => [
                    [ 'The renovation experience should feel organized', 'MJL brings the planning, trade coordination and communication required to move a major renovation forward without unnecessary confusion. You receive a clear scope, realistic expectations and one accountable team from first conversation through final walkthrough.' ],
                    [ 'Built for how you actually live', 'We balance layout, storage, durability, lighting and finishes so your home looks exceptional and functions better every day. Every recommendation is tied back to your priorities, budget and long-term plans.' ],
                ],
                'faq' => [
                    [ 'Which areas do you serve?', 'Burlington, Oakville, Waterdown, Hamilton, Ancaster, Dundas, Stoney Creek, Milton and Flamborough.' ],
                    [ 'Do you provide estimates?', 'Yes. We begin with a project conversation, confirm fit and arrange a site visit where appropriate before preparing a detailed proposal.' ],
                    [ 'Can you manage permits and trades?', 'Yes. Permit, engineering and specialty-trade requirements are identified during planning and included in the agreed project scope.' ],
                ],
                'seo_title' => 'Home Renovations Burlington, Oakville & Hamilton | MJL Construction',
                'meta' => 'Premium kitchen, bathroom, basement and whole-home renovations in Burlington, Oakville, Waterdown, Hamilton and surrounding communities.'
            ],
            'kitchen-renovations' => [
                'title' => 'Kitchen Renovations', 'eyebrow' => 'KITCHEN RENOVATIONS',
                'headline' => 'A Kitchen Designed Around Real Life',
                'intro' => 'Create a kitchen that works harder, feels larger and brings the entire home together—from cabinetry and lighting to structural changes and final finishes.',
                'image' => 'https://images.unsplash.com/photo-1556912167-f556f1f39fdf?auto=format&fit=crop&w=2000&q=85',
                'sections' => [
                    [ 'More than new cabinets', 'A strong kitchen renovation solves circulation, storage, lighting, appliance placement and sightlines. We review the room as part of the wider home so every decision contributes to a coherent result.' ],
                    [ 'Scope we can coordinate', 'Custom and semi-custom cabinetry, islands, quartz and stone surfaces, backsplash, plumbing, electrical, lighting, flooring, painting, appliance coordination, structural openings, permits and finishing details.' ],
                    [ 'Investment planning', 'Kitchen budgets depend heavily on layout changes, cabinetry, appliances, finish level and structural work. The project form adapts budget options to the type of work selected so the first conversation is grounded in the right range.' ],
                ],
                'faq' => [
                    [ 'How long does a kitchen renovation take?', 'A straightforward kitchen may take several weeks of construction. Structural changes, custom cabinetry and broader main-floor work require a longer schedule. Your proposal will identify the expected sequence.' ],
                    [ 'Can you open the kitchen to another room?', 'Often, yes. We assess load-bearing conditions and coordinate engineering and permits where structural changes are required.' ],
                    [ 'Do you help with selections?', 'Yes. We help organize key selections and deadlines so cabinetry, fixtures, surfaces and finishes are ready when the schedule requires them.' ],
                ],
                'seo_title' => 'Kitchen Renovations Burlington & Oakville | MJL Construction',
                'meta' => 'Premium kitchen renovations, structural openings, cabinetry, islands and complete project management in Burlington, Oakville and surrounding areas.'
            ],
            'bathroom-renovations' => [
                'title' => 'Bathroom Renovations', 'eyebrow' => 'BATHROOM RENOVATIONS',
                'headline' => 'A Better Start and Finish to Every Day',
                'intro' => 'Thoughtful layouts, durable waterproofing and refined finishes come together in bathrooms built for comfort, storage and long-term performance.',
                'image' => 'https://images.unsplash.com/photo-1620626011761-996317b8d101?auto=format&fit=crop&w=2000&q=85',
                'sections' => [
                    [ 'Performance behind the finishes', 'The details you do not see matter most in a bathroom. We prioritize proper substrate preparation, waterproofing, ventilation, plumbing and electrical work before tile and fixtures are installed.' ],
                    [ 'Complete bathroom scope', 'Walk-in showers, tubs, custom glass, vanities, stone counters, heated floors, tile, lighting, ventilation, storage, accessibility upgrades, plumbing relocations and complete finishing.' ],
                    [ 'Designed for the room you have', 'We look for opportunities to improve circulation and storage without forcing impractical features into the space. The result should feel calm, efficient and proportionate.' ],
                ],
                'faq' => [
                    [ 'Can you relocate plumbing?', 'Yes, where site conditions allow. Relocation can materially affect cost, so we assess it early.' ],
                    [ 'Do you install heated floors?', 'Yes. Electric floor warming is a popular option and can be coordinated with the tile assembly and electrical plan.' ],
                    [ 'Can one bathroom remain usable during the work?', 'That depends on the home and project scope. We discuss access and sequencing before construction begins.' ],
                ],
                'seo_title' => 'Bathroom Renovations Burlington & Oakville | MJL Construction',
                'meta' => 'Complete bathroom renovations, walk-in showers, heated floors, tile and custom vanities across Burlington, Oakville and nearby communities.'
            ],
            'basement-renovations' => [
                'title' => 'Basement Renovations', 'eyebrow' => 'BASEMENT RENOVATIONS',
                'headline' => 'Turn Underused Space Into Valuable Living Space',
                'intro' => 'Create a comfortable lower level for family life, entertaining, work, guests or additional income—with the planning required to make it feel like part of the home.',
                'image' => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=2000&q=85',
                'sections' => [
                    [ 'Plan around the realities of the basement', 'Ceiling heights, mechanical systems, moisture management, insulation, egress and existing structure all shape the best design. We address those conditions before finalizing the layout.' ],
                    [ 'Basement possibilities', 'Family rooms, home theatres, bars, offices, gyms, guest rooms, bathrooms, laundry rooms, playrooms, storage and legal-suite preparation where permitted.' ],
                    [ 'Comfort matters', 'Good lighting, heating, sound control and thoughtful finishes prevent the basement from feeling like an afterthought. The design should connect naturally to the rest of the home.' ],
                ],
                'faq' => [
                    [ 'Do basement renovations require permits?', 'Many do, especially when adding bedrooms, bathrooms, kitchens, structural work or major electrical and plumbing changes. Requirements are confirmed during planning.' ],
                    [ 'Can you build a legal basement suite?', 'We can plan and build toward legal requirements where zoning, building conditions and municipal approvals allow.' ],
                    [ 'How do you handle low ceilings and bulkheads?', 'We coordinate framing and mechanical routing carefully, then use lighting, colour and millwork to reduce their visual impact.' ],
                ],
                'seo_title' => 'Basement Renovations Burlington, Hamilton & Waterdown | MJL',
                'meta' => 'Basement finishing and renovations for family rooms, offices, bathrooms, bars and suites in Burlington, Hamilton, Waterdown and nearby areas.'
            ],
            'whole-home-renovations' => [
                'title' => 'Whole Home Renovations', 'eyebrow' => 'WHOLE HOME & FULL GUT RENOVATIONS',
                'headline' => 'Rebuild the Home You Love Into the Home You Need',
                'intro' => 'For homes requiring major layout changes, comprehensive modernization or a full interior rebuild, MJL coordinates the project as one integrated scope.',
                'image' => 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=2000&q=85',
                'sections' => [
                    [ 'One plan across the entire home', 'Whole-home work is not a collection of separate rooms. Structural, mechanical, electrical, plumbing, envelope and finish decisions must work together. We sequence those decisions before demolition begins.' ],
                    [ 'Typical scope', 'Full demolition, structural modifications, stair and railing work, kitchens, bathrooms, flooring, millwork, drywall, insulation, windows and doors, lighting, plumbing, HVAC coordination and complete finishing.' ],
                    [ 'Communication at the right level', 'Large projects need regular updates, documented decisions and clear responsibility. We establish the process early so the project remains understandable as it moves through complex stages.' ],
                ],
                'faq' => [
                    [ 'Should we renovate or rebuild?', 'That depends on structure, zoning, desired outcome, budget and the value of the existing home. An initial assessment helps identify which path deserves further study.' ],
                    [ 'Can we live in the home during construction?', 'For a full-gut renovation, moving out is normally the practical choice. Limited occupancy may be possible on some phased projects.' ],
                    [ 'How early should planning begin?', 'Several months before the preferred construction start. Design, engineering, permits and selections can take substantial time.' ],
                ],
                'seo_title' => 'Whole Home & Full Gut Renovations Burlington | MJL Construction',
                'meta' => 'Whole-home renovations, full-gut remodels and major structural transformations in Burlington, Oakville, Waterdown and surrounding areas.'
            ],
            'custom-home-building' => [
                'title' => 'Custom Home Building', 'eyebrow' => 'CUSTOM HOME BUILDING',
                'headline' => 'Build Deliberately From the Ground Up',
                'intro' => 'A custom home requires hundreds of coordinated decisions. MJL brings practical construction thinking, accountable management and quality control to the process.',
                'image' => 'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?auto=format&fit=crop&w=2000&q=85',
                'sections' => [
                    [ 'A construction partner early in the process', 'Builder input during design can prevent avoidable cost and constructability issues. We collaborate with architects, designers, engineers and specialty consultants to move the concept toward a buildable plan.' ],
                    [ 'Managed from site preparation to completion', 'Site logistics, permits, foundations, framing, building envelope, mechanical systems, interiors, exterior work, inspections, scheduling, trade coordination and turnover.' ],
                    [ 'Cost and quality need active management', 'Custom building involves constant choices. We document allowances, identify decision deadlines and maintain a clear view of how changes affect cost and schedule.' ],
                ],
                'faq' => [
                    [ 'Do I need architectural drawings before contacting you?', 'No. Early contact is useful. We can discuss feasibility and the professionals required before the design advances too far.' ],
                    [ 'Can you build on an existing lot?', 'Yes, subject to site access, zoning, servicing, approvals and the feasibility of the proposed home.' ],
                    [ 'How long does a custom home take?', 'Timelines vary considerably based on design, approvals, site conditions and complexity. Planning and approvals occur before the construction schedule begins.' ],
                ],
                'seo_title' => 'Custom Home Builder Burlington, Oakville & Waterdown | MJL',
                'meta' => 'Custom home construction and project management in Burlington, Oakville, Waterdown, Hamilton and surrounding communities.'
            ],
            'renovation-process' => [
                'title' => 'Our Renovation Process', 'eyebrow' => 'OUR PROCESS',
                'headline' => 'A Clearer Path From Idea to Completion',
                'intro' => 'Major projects become manageable when decisions happen in the right order. Our process is designed to improve clarity before construction and accountability during it.',
                'image' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=2000&q=85',
                'process' => true,
                'sections' => [
                    [ 'Planning protects the build', 'The earlier we identify priorities, constraints, approvals and selections, the fewer disruptive decisions need to be made on site.' ],
                    [ 'Changes are documented', 'Renovations can uncover conditions that were not visible beforehand. When scope changes, the impact on cost and schedule should be understood before work proceeds.' ],
                ],
                'seo_title' => 'Our Renovation Process | MJL Construction',
                'meta' => 'Learn how MJL Construction plans and manages renovations, from consultation and design through construction and final walkthrough.'
            ],
            'renovation-portfolio' => [
                'title' => 'Renovation Portfolio', 'eyebrow' => 'OUR WORK',
                'headline' => 'Craftsmanship Is Easier to Understand When You Can See It',
                'intro' => 'This portfolio framework is ready for your real project photography, before-and-after images and detailed case studies.',
                'image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=2000&q=85',
                'portfolio' => true,
                'sections' => [
                    [ 'Replace placeholders with real work before publishing', 'The page is intentionally built with clearly labelled project placeholders. Add location, scope, timeline, investment range and the story behind each project to make the portfolio more credible and useful.' ],
                ],
                'seo_title' => 'Renovation Portfolio | MJL Construction',
                'meta' => 'Explore kitchen, bathroom, basement, whole-home and custom-home projects completed by MJL Construction.'
            ],
            'renovation-financing' => [
                'title' => 'Renovation Financing', 'eyebrow' => 'PROJECT PLANNING',
                'headline' => 'Plan the Project Around the Right Investment',
                'intro' => 'A major renovation should begin with a realistic view of scope, priorities and available capital. We help clients align design decisions with the overall investment.',
                'image' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=2000&q=85',
                'sections' => [
                    [ 'Transparent scope before construction', 'A useful proposal should explain what is included, identify allowances and clarify exclusions. The goal is not simply a low starting number—it is a credible plan for the work being requested.' ],
                    [ 'Financing availability', 'Financing language and monthly-payment examples should only be published after MJL has selected and approved a financing provider. Until then, this page focuses on budgeting and phased planning without making lending claims.' ],
                    [ 'Prioritize where the money matters', 'Structure, waterproofing, mechanical work and core functionality come first. Finish selections can then be balanced to protect the design without undermining the fundamentals.' ],
                ],
                'seo_title' => 'Renovation Budget Planning | MJL Construction',
                'meta' => 'Plan renovation scope, priorities and investment with MJL Construction before starting a kitchen, basement or whole-home project.'
            ],
            'about-mjl-renovations' => [
                'title' => 'About MJL Renovations', 'eyebrow' => 'ABOUT MJL',
                'headline' => 'Quality Work Requires More Than Skilled Hands',
                'intro' => 'MJL Construction combines hands-on building experience with the planning, communication and accountability expected on substantial residential projects.',
                'image' => 'https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?auto=format&fit=crop&w=2000&q=85',
                'sections' => [
                    [ 'Locally focused', 'We serve homeowners in Burlington, Oakville, Waterdown, Hamilton, Ancaster, Dundas, Stoney Creek, Milton and Flamborough.' ],
                    [ 'Built around responsibility', 'Clients should know who is accountable for the schedule, trade coordination, decisions and quality. MJL keeps responsibility visible throughout the work.' ],
                    [ 'Premium does not mean wasteful', 'A premium renovation is well considered, properly executed and durable. It is not defined by adding expensive features without purpose.' ],
                ],
                'seo_title' => 'About MJL Construction | Renovations & Custom Homes',
                'meta' => 'Learn about MJL Construction and our approach to premium residential renovations and custom-home building in the western GTA and Hamilton area.'
            ],
            'renovation-reviews' => [
                'title' => 'Client Reviews', 'eyebrow' => 'CLIENT EXPERIENCE',
                'headline' => 'Trust Is Earned During the Work',
                'intro' => 'Real reviews should speak to communication, organization, problem solving, workmanship and how the finished space performs—not just how it looks in photos.',
                'image' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=2000&q=85',
                'reviews' => true,
                'sections' => [
                    [ 'Add verified reviews before publishing', 'This page includes review placeholders rather than invented testimonials. Replace each one with a genuine Google, Facebook or direct client review and obtain permission where required.' ],
                ],
                'seo_title' => 'MJL Construction Reviews | Burlington Renovation Contractor',
                'meta' => 'Read verified client reviews for MJL Construction renovation and building projects in Burlington and surrounding communities.'
            ],
            'renovation-contact' => [
                'title' => 'Start Your Renovation', 'eyebrow' => 'CONTACT MJL',
                'headline' => 'Tell Us What You Are Planning',
                'intro' => 'Share the property, project type, target timing and what you want to improve. We will review the information and contact you about the appropriate next step.',
                'image' => 'https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=2000&q=85',
                'contact' => true,
                'sections' => [
                    [ 'Inquiries accepted 24/7', 'Consultations and site visits are scheduled by appointment. Call 289-828-1933 or email info@mjlconstruction.ca.' ],
                ],
                'seo_title' => 'Contact MJL Construction | Start Your Renovation',
                'meta' => 'Contact MJL Construction about a kitchen, bathroom, basement, whole-home renovation or custom home in Burlington and surrounding areas.'
            ],
        ];
    }

    private function render_page( $p ) {
        $services = '';
        if ( ! empty( $p['services'] ) ) {
            $cards = [
                [ 'Kitchen Renovations', 'Purposeful layouts, cabinetry, surfaces, lighting and structural changes.', '/kitchen-renovations/' ],
                [ 'Bathroom Renovations', 'Durable waterproofing, thoughtful storage and refined, comfortable finishes.', '/bathroom-renovations/' ],
                [ 'Basement Renovations', 'Comfortable lower levels for family, work, guests, fitness and entertaining.', '/basement-renovations/' ],
                [ 'Whole Home Renovations', 'Integrated planning for major transformations and complete interior rebuilds.', '/whole-home-renovations/' ],
                [ 'Custom Home Building', 'Coordinated construction management from early planning through turnover.', '/custom-home-building/' ],
            ];
            foreach ( $cards as $c ) $services .= '<a class="mjl-card" href="' . esc_url( home_url( $c[2] ) ) . '"><span class="mjl-card__number">0' . ( substr_count( $services, 'mjl-card' ) + 1 ) . '</span><h3>' . esc_html( $c[0] ) . '</h3><p>' . esc_html( $c[1] ) . '</p><span class="mjl-link">Explore service →</span></a>';
            $services = '<section class="mjl-section mjl-section--warm"><div class="mjl-wrap"><div class="mjl-kicker">RENOVATION SERVICES</div><h2>One Team for the Entire Home</h2><div class="mjl-grid mjl-grid--services">' . $services . '</div></div></section>';
        }

        $sections = '';
        foreach ( $p['sections'] ?? [] as $i => $s ) {
            $sections .= '<article class="mjl-split ' . ( $i % 2 ? 'mjl-split--reverse' : '' ) . '"><div class="mjl-split__visual"><div class="mjl-placeholder"><span>PROJECT IMAGE</span><small>Replace with authentic MJL photography</small></div></div><div class="mjl-split__copy"><div class="mjl-kicker">0' . ( $i + 1 ) . '</div><h2>' . esc_html( $s[0] ) . '</h2><p>' . esc_html( $s[1] ) . '</p><a class="mjl-text-link" href="' . esc_url( home_url( '/renovation-contact/' ) ) . '">Discuss your project →</a></div></article>';
        }
        if ( $sections ) $sections = '<section class="mjl-section"><div class="mjl-wrap">' . $sections . '</div></section>';

        $process = '';
        if ( ! empty( $p['process'] ) ) {
            $steps = [
                [ '01', 'Initial conversation', 'We discuss the property, desired outcome, timing and likely investment range to determine fit.' ],
                [ '02', 'Site review', 'We assess existing conditions, constraints and the professionals or approvals likely to be required.' ],
                [ '03', 'Scope and planning', 'The project is defined through drawings, specifications, allowances and selection deadlines.' ],
                [ '04', 'Proposal and schedule', 'You receive a written scope, investment and expected project sequence.' ],
                [ '05', 'Construction', 'MJL coordinates trades, site activity, communication, quality checks and documented changes.' ],
                [ '06', 'Completion', 'We complete deficiencies, review the finished work and organize closeout information.' ],
            ];
            foreach ( $steps as $s ) $process .= '<div class="mjl-step"><span>' . $s[0] . '</span><h3>' . $s[1] . '</h3><p>' . $s[2] . '</p></div>';
            $process = '<section class="mjl-section mjl-section--dark"><div class="mjl-wrap"><div class="mjl-kicker">FROM FIRST CALL TO FINAL WALKTHROUGH</div><h2>Six Deliberate Stages</h2><div class="mjl-grid mjl-grid--steps">' . $process . '</div></div></section>';
        }

        $portfolio = '';
        if ( ! empty( $p['portfolio'] ) ) {
            foreach ( [ 'Burlington Kitchen Transformation', 'Oakville Primary Bathroom', 'Waterdown Basement Living Space', 'Hamilton Whole-Home Renovation', 'Ancaster Custom Home' ] as $name ) {
                $portfolio .= '<article class="mjl-project"><div class="mjl-project__image"><span>ADD REAL PROJECT PHOTO</span></div><div><div class="mjl-kicker">CASE STUDY PLACEHOLDER</div><h3>' . esc_html( $name ) . '</h3><p>Add actual location, scope, timeline, challenges, solution and approved investment range.</p></div></article>';
            }
            $portfolio = '<section class="mjl-section"><div class="mjl-wrap"><div class="mjl-projects">' . $portfolio . '</div></div></section>';
        }

        $reviews = '';
        if ( ! empty( $p['reviews'] ) ) {
            $reviews = '<section class="mjl-section mjl-section--warm"><div class="mjl-wrap"><div class="mjl-grid mjl-grid--reviews">' .
                '<blockquote>“Replace this with a verified client review describing the planning, communication and completed work.”<cite>Verified client name · Project type</cite></blockquote>' .
                '<blockquote>“Do not publish invented testimonials. Add a real Google or Facebook review here.”<cite>Verified client name · City</cite></blockquote>' .
                '<blockquote>“Use specific reviews that show how MJL handled challenges and delivered the final result.”<cite>Verified client name · Project type</cite></blockquote>' .
                '</div></div></section>';
        }

        $faq = '';
        foreach ( $p['faq'] ?? [] as $f ) $faq .= '<details><summary>' . esc_html( $f[0] ) . '</summary><p>' . esc_html( $f[1] ) . '</p></details>';
        if ( $faq ) $faq = '<section class="mjl-section mjl-section--warm"><div class="mjl-wrap mjl-wrap--narrow"><div class="mjl-kicker">COMMON QUESTIONS</div><h2>What Homeowners Ask First</h2><div class="mjl-faq">' . $faq . '</div></div></section>';

        $contact = ! empty( $p['contact'] ) ? '<section class="mjl-section"><div class="mjl-wrap mjl-contact-layout"><div><div class="mjl-kicker">PROJECT INQUIRY</div><h2>Start With the Details</h2><p>Phone: <a href="tel:+12898281933">289-828-1933</a><br>Email: <a href="mailto:info@mjlconstruction.ca">info@mjlconstruction.ca</a><br>Instagram: <a href="https://instagram.com/mjlconstruction_">@mjlconstruction_</a></p></div><div>[mjl_renovation_form]</div></div></section>' : '';

        return '<div class="mjl-reno-page">' .
            '<header class="mjl-sitebar"><a class="mjl-wordmark" href="' . esc_url( home_url( '/' ) ) . '">MJL <span>CONSTRUCTION</span></a><nav><a href="' . esc_url( home_url( '/renovations/' ) ) . '">Renovations</a><a href="' . esc_url( home_url( '/renovation-portfolio/' ) ) . '">Portfolio</a><a href="' . esc_url( home_url( '/renovation-process/' ) ) . '">Process</a><a href="' . esc_url( home_url( '/renovation-contact/' ) ) . '" class="mjl-nav-cta">Start a Project</a></nav></header>' .
            '<section class="mjl-hero" style="--mjl-hero:url(\'' . esc_url( $p['image'] ) . '\')"><div class="mjl-hero__overlay"></div><div class="mjl-wrap mjl-hero__content"><div class="mjl-kicker">' . esc_html( $p['eyebrow'] ) . '</div><h1>' . esc_html( $p['headline'] ) . '</h1><p>' . esc_html( $p['intro'] ) . '</p><div class="mjl-actions"><a class="mjl-button" href="' . esc_url( home_url( '/renovation-contact/' ) ) . '">Start Your Project</a><a class="mjl-button mjl-button--ghost" href="tel:+12898281933">289-828-1933</a></div></div></section>' .
            '<section class="mjl-trust"><div>Premium residential work</div><div>Clear project communication</div><div>Serving the western GTA & Hamilton area</div></section>' .
            $services . $process . $portfolio . $reviews . $sections . $faq . $contact .
            '<section class="mjl-final"><div class="mjl-wrap"><div><div class="mjl-kicker">READY TO BEGIN?</div><h2>Let’s Discuss the Home You Want to Create</h2></div><a class="mjl-button" href="' . esc_url( home_url( '/renovation-contact/' ) ) . '">Request a Consultation</a></div></section>' .
            '<footer class="mjl-footer"><div class="mjl-wrap"><div><strong>MJL CONSTRUCTION</strong><p>Renovations and custom homes across Burlington, Oakville, Waterdown, Hamilton, Ancaster, Dundas, Stoney Creek, Milton and Flamborough.</p></div><div><a href="tel:+12898281933">289-828-1933</a><br><a href="mailto:info@mjlconstruction.ca">info@mjlconstruction.ca</a><br><span>Inquiries accepted 24/7. Consultations by appointment.</span></div><div><a href="https://instagram.com/mjlconstruction_">Instagram</a><br><a href="http://facebook.com/profile.php?id=61558061859830">Facebook</a></div></div></footer>' .
            '</div>';
    }

    public function form_shortcode() {
        $action = esc_url( 'mailto:info@mjlconstruction.ca' );
        return '<form class="mjl-form" action="' . $action . '" method="post" enctype="text/plain">' .
            '<div class="mjl-form__grid"><label>Name<input required name="Name"></label><label>Email<input required type="email" name="Email"></label><label>Phone<input required type="tel" name="Phone"></label><label>Project location<input name="Project location" placeholder="City or postal code"></label></div>' .
            '<label>Project type<select required name="Project type" data-mjl-project><option value="">Select one</option><option>Kitchen renovation</option><option>Bathroom renovation</option><option>Basement renovation</option><option>Whole-home or full-gut renovation</option><option>Custom home</option><option>Other</option></select></label>' .
            '<label>Estimated investment<select required name="Estimated investment" data-mjl-budget><option value="">Select project type first</option></select></label>' .
            '<label>Desired start<select name="Desired start"><option>As soon as practical</option><option>Within 3 months</option><option>3–6 months</option><option>6–12 months</option><option>More than 12 months</option></select></label>' .
            '<label>Tell us about the project<textarea required name="Project details" rows="6"></textarea></label>' .
            '<label class="mjl-consent"><input required type="checkbox"> I agree to be contacted by MJL Construction about this inquiry.</label>' .
            '<button class="mjl-button" type="submit">Submit Project Details</button><p class="mjl-form__note">This starter form opens the visitor’s email application. Replace it with Formidable Forms before launch to store submissions, upload photos and send reliable notifications.</p></form>';
    }
}

new MJL_Renovations_Builder();
