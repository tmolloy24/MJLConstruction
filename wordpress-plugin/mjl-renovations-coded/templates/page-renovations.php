<?php
if (!defined('ABSPATH')) exit;
$post_id = get_queried_object_id();
$kind = get_post_meta($post_id, '_mjl_reno_kind', true) ?: 'service';
$eyebrow = get_post_meta($post_id, '_mjl_reno_eyebrow', true);
$headline = get_post_meta($post_id, '_mjl_reno_headline', true);
$intro = get_post_meta($post_id, '_mjl_reno_intro', true);
$hero = get_post_meta($post_id, '_mjl_reno_hero', true);
$logo = MJL_Renovations_Coded::logo_data_uri();
$service_cards = [
 ['Kitchen Renovations','Thoughtful layouts, cabinetry, surfaces, lighting and structural changes.','/kitchen-renovations/','https://images.unsplash.com/photo-1556912167-f556f1f39fdf?auto=format&fit=crop&w=1200&q=82'],
 ['Bathroom Renovations','Comfort, storage, waterproofing and refined finishes.','/bathroom-renovations/','https://images.unsplash.com/photo-1620626011761-996317b8d101?auto=format&fit=crop&w=1200&q=82'],
 ['Basement Renovations','Living, work, fitness, guest and entertainment spaces.','/basement-renovations/','https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1200&q=82'],
 ['Whole Home Renovations','Integrated planning for major transformations and full-gut work.','/whole-home-renovations/','https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1200&q=82'],
 ['Custom Home Building','Coordinated construction management from planning through turnover.','/custom-home-building/','https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?auto=format&fit=crop&w=1200&q=82'],
];
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width,initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="mjr-header">
 <div class="mjr-wrap mjr-header__inner">
  <a class="mjr-brand" href="<?php echo esc_url(home_url('/renovations/')); ?>">
   <img src="<?php echo esc_attr($logo); ?>" alt="MJL Renovations">
   <span><strong>MJL</strong><small>RENOVATIONS</small></span>
  </a>
  <button class="mjr-menu-toggle" aria-expanded="false" aria-controls="mjr-nav">Menu</button>
  <nav id="mjr-nav" class="mjr-nav">
   <a href="<?php echo esc_url(home_url('/renovations/')); ?>">Home</a>
   <a href="<?php echo esc_url(home_url('/kitchen-renovations/')); ?>">Services</a>
   <a href="<?php echo esc_url(home_url('/renovation-portfolio/')); ?>">Portfolio</a>
   <a href="<?php echo esc_url(home_url('/renovation-process/')); ?>">Process</a>
   <a href="<?php echo esc_url(home_url('/about-mjl-renovations/')); ?>">About</a>
   <a class="mjr-button mjr-button--small" href="<?php echo esc_url(home_url('/renovation-contact/')); ?>">Get Estimate</a>
  </nav>
 </div>
</header>

<main>
<section class="mjr-hero" style="--hero:url('<?php echo esc_url($hero); ?>')">
 <div class="mjr-hero__shade"></div>
 <div class="mjr-wrap mjr-hero__content">
  <div class="mjr-eyebrow"><?php echo esc_html($eyebrow); ?></div>
  <h1><?php echo esc_html($headline); ?></h1>
  <p><?php echo esc_html($intro); ?></p>
  <div class="mjr-actions">
   <a class="mjr-button" href="<?php echo esc_url(home_url('/renovation-contact/')); ?>">Start Your Project</a>
   <a class="mjr-button mjr-button--outline" href="<?php echo esc_url(home_url('/renovation-portfolio/')); ?>">View Our Work</a>
  </div>
 </div>
</section>

<section class="mjr-trust">
 <div class="mjr-wrap mjr-trust__grid">
  <div><strong>One team</strong><span>From planning through completion</span></div>
  <div><strong>Clear communication</strong><span>Defined scope and regular updates</span></div>
  <div><strong>Premium craftsmanship</strong><span>Thoughtful details built to last</span></div>
  <div><strong>Local service</strong><span>Western GTA and Hamilton area</span></div>
 </div>
</section>

<?php if ($kind === 'home'): ?>
<section class="mjr-section mjr-section--cream">
 <div class="mjr-wrap">
  <div class="mjr-section-heading"><div class="mjr-eyebrow">RENOVATION SERVICES</div><h2>One Team for the Entire Home</h2></div>
  <div class="mjr-service-grid">
  <?php foreach ($service_cards as $card): ?>
   <a class="mjr-service-card" href="<?php echo esc_url(home_url($card[2])); ?>" style="--card:url('<?php echo esc_url($card[3]); ?>')">
    <div class="mjr-service-card__shade"></div><div><h3><?php echo esc_html($card[0]); ?></h3><p><?php echo esc_html($card[1]); ?></p><span>Explore service →</span></div>
   </a>
  <?php endforeach; ?>
  </div>
 </div>
</section>
<?php endif; ?>

<section class="mjr-section">
 <div class="mjr-wrap mjr-editorial">
  <div class="mjr-editorial__image" style="background-image:url('https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?auto=format&fit=crop&w=1500&q=84')"></div>
  <div class="mjr-editorial__copy">
   <div class="mjr-eyebrow">THOUGHTFUL FROM THE START</div>
   <?php while (have_posts()): the_post(); the_content(); endwhile; ?>
   <ul class="mjr-checks"><li>One accountable point of contact</li><li>Detailed project planning</li><li>Transparent scope and communication</li><li>Respect for your home and schedule</li></ul>
   <a class="mjr-text-link" href="<?php echo esc_url(home_url('/renovation-process/')); ?>">See our process →</a>
  </div>
 </div>
</section>

<?php if ($kind === 'process'): ?>
<section class="mjr-section mjr-section--dark"><div class="mjr-wrap"><div class="mjr-section-heading"><div class="mjr-eyebrow">FROM FIRST CALL TO FINAL WALKTHROUGH</div><h2>Six Deliberate Stages</h2></div><div class="mjr-process">
<?php foreach ([['01','Consultation'],['02','Site review'],['03','Planning'],['04','Proposal'],['05','Construction'],['06','Completion']] as $step): ?>
<div><span><?php echo $step[0]; ?></span><h3><?php echo esc_html($step[1]); ?></h3><p>Clear expectations, defined decisions and accountable communication at every stage.</p></div>
<?php endforeach; ?>
</div></div></section>
<?php endif; ?>

<?php if ($kind === 'portfolio'): ?>
<section class="mjr-section mjr-section--cream"><div class="mjr-wrap"><div class="mjr-project-grid">
<?php $projects = new WP_Query(['post_type'=>'mjl_project','posts_per_page'=>9]); if ($projects->have_posts()): while($projects->have_posts()): $projects->the_post(); ?>
<article class="mjr-project-card"><?php if(has_post_thumbnail()) the_post_thumbnail('large'); ?><div><h3><?php the_title(); ?></h3><p><?php echo esc_html(get_the_excerpt()); ?></p></div></article>
<?php endwhile; wp_reset_postdata(); else: ?>
<div class="mjr-empty"><h2>Add your first real project</h2><p>Go to MJL Projects in WordPress and add project photography, the city, scope and story.</p></div>
<?php endif; ?>
</div></div></section>
<?php endif; ?>

<?php if ($kind === 'contact'): ?>
<section class="mjr-section mjr-section--cream"><div class="mjr-wrap mjr-contact">
<div><div class="mjr-eyebrow">PROJECT INQUIRY</div><h2>Start With the Details</h2><p><a href="tel:+12898281933">289-828-1933</a><br><a href="mailto:info@mjlconstruction.ca">info@mjlconstruction.ca</a></p><p>Inquiries accepted 24/7. Consultations by appointment.</p></div>
<div class="mjr-form"><?php echo shortcode_exists('formidable') ? do_shortcode('[formidable id="contact"]') : '<h3>Connect your Formidable form</h3><p>Create the form, then replace the placeholder shortcode in templates/page-renovations.php.</p>'; ?></div>
</div></section>
<?php endif; ?>

<section class="mjr-section mjr-section--cream">
 <div class="mjr-wrap mjr-faq">
  <div class="mjr-eyebrow">COMMON QUESTIONS</div><h2>What Homeowners Ask First</h2>
  <details><summary>Which areas do you serve?</summary><p>Burlington, Oakville, Waterdown, Hamilton, Ancaster, Dundas, Stoney Creek, Milton and Flamborough.</p></details>
  <details><summary>How does the estimate process work?</summary><p>We begin with a project conversation, confirm fit and arrange a site review where appropriate before preparing a written proposal.</p></details>
  <details><summary>Can MJL coordinate permits and trades?</summary><p>Permit, engineering and specialty-trade requirements are identified during planning and included in the agreed project scope.</p></details>
 </div>
</section>

<section class="mjr-cta"><div class="mjr-wrap"><div><div class="mjr-eyebrow">READY TO BEGIN?</div><h2>Let’s Build Something Exceptional</h2></div><a class="mjr-button" href="<?php echo esc_url(home_url('/renovation-contact/')); ?>">Request a Consultation</a></div></section>
</main>

<footer class="mjr-footer"><div class="mjr-wrap mjr-footer__grid">
<div><div class="mjr-brand mjr-brand--footer"><img src="<?php echo esc_attr($logo); ?>" alt=""><span><strong>MJL</strong><small>RENOVATIONS</small></span></div><p>Premium renovations and custom homes across Burlington, Oakville, Waterdown, Hamilton and surrounding communities.</p></div>
<div><h3>Services</h3><a href="<?php echo esc_url(home_url('/kitchen-renovations/')); ?>">Kitchens</a><a href="<?php echo esc_url(home_url('/bathroom-renovations/')); ?>">Bathrooms</a><a href="<?php echo esc_url(home_url('/basement-renovations/')); ?>">Basements</a><a href="<?php echo esc_url(home_url('/whole-home-renovations/')); ?>">Whole Home</a></div>
<div><h3>Contact</h3><a href="tel:+12898281933">289-828-1933</a><a href="mailto:info@mjlconstruction.ca">info@mjlconstruction.ca</a><a href="https://instagram.com/mjlconstruction_">Instagram</a><a href="http://facebook.com/profile.php?id=61558061859830">Facebook</a></div>
</div><div class="mjr-wrap mjr-footer__bottom">© <?php echo date('Y'); ?> MJL Construction. All rights reserved.</div></footer>
<?php wp_footer(); ?>
</body></html>
