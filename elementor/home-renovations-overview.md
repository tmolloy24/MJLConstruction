# Elementor Build Specification — Renovations Overview

## Page purpose

Create the main renovation hub on `mjlconstruction.ca`. This page introduces MJL's interior renovation and custom-home services, qualifies prospective clients, and routes them to the appropriate service page or consultation form.

Recommended URL: `/home-renovations/`

Recommended page template: **Elementor Full Width**

Hide default Astra page title.

## Elementor global setup

Before building, configure Elementor Site Settings:

### Global colours

- Primary: `#151515`
- Secondary: `#242424`
- Text: `#4B4B4B`
- Accent: `#B9985A`
- Warm white: `#F8F6F2`
- White: `#FFFFFF`
- Border: `#DED9CF`

### Global fonts

- Primary/headings: Oswald, 600
- Secondary/body: Roboto, 400
- Accent/labels: Oswald, 600, uppercase

### Content width

- 1240px
- Container gap: 24px

Add the CSS from `css/mjl-renovations-global.css` through Elementor Pro Custom CSS, Astra child theme, or Code Snippets configured for front-end CSS.

---

# Section 1 — Hero

## Container settings

- Full width container
- Minimum height: 720px desktop, 640px tablet, 620px mobile
- Content width: boxed, 1240px
- Vertical alignment: centre
- CSS class: `mjl-hero`
- Background: premium completed whole-home or kitchen project
- Background position: centre centre
- Padding: 120px 32px desktop, 88px 24px tablet, 72px 20px mobile

## Inner content

Limit text column to approximately 720px.

### Eyebrow

**Premium Renovations & Custom Homes**

CSS class: `mjl-eyebrow`

### H1

**Renovations Built Around the Way You Live**

### Supporting copy

MJL Construction delivers carefully planned kitchens, bathrooms, basements, whole-home transformations and custom homes across Burlington, Oakville, Waterdown and surrounding communities.

### Buttons

Primary: **Start Your Renovation**

Link: page anchor `#consultation`

CSS class on Button widget: `mjl-btn`

Secondary: **Explore Our Services**

Link: page anchor `#services`

CSS classes: `mjl-btn mjl-btn--outline`

### Small trust line

**Clear communication. Detailed project management. Premium craftsmanship.**

Use 14px white at 75% opacity.

---

# Section 2 — Trust bar

## Container

- Full width
- Background: `#242424`
- CSS class: `mjl-trust-bar`
- Padding: 22px 32px

## Items

Use four equal horizontal items on desktop and a 2x2 grid on mobile:

- Fully insured
- WSIB compliant
- Experienced local trades
- Consultations by appointment

Use simple line icons in muted gold. Do not use oversized badges.

---

# Section 3 — Introduction

## Container

- Boxed, 1240px
- Two columns: 42% / 58%
- Gap: 72px
- Padding: 112px 32px
- Background: `#F8F6F2`

### Left column

Eyebrow: **A Better Renovation Experience**

H2: **Thoughtfully Planned. Carefully Built.**

### Right column copy

A major renovation is about more than selecting finishes. It requires a clear scope, dependable scheduling, skilled trades and consistent communication from the first site visit through the final walkthrough.

MJL Construction brings those pieces together under one accountable team. We help homeowners make informed decisions, coordinate the work and build spaces that feel considered, functional and made to last.

Add a text link: **See How Our Process Works →**

Link to `/renovation-process/`

CSS class: `mjl-link-arrow`

---

# Section 4 — Services grid

Anchor ID: `services`

## Intro

Eyebrow: **Renovation Services**

H2: **From One Room to a Complete Transformation**

Supporting copy:

Choose a focused renovation or work with MJL on a complete redesign and rebuild of your home.

## Grid

Use six service cards in a 3-column desktop, 2-column tablet, 1-column mobile grid.

Each card:

- 4:3 image
- Service title
- 40–55 word description
- Specific text link
- CSS classes: card container `mjl-card`; image wrapper `mjl-image-zoom`; text link `mjl-link-arrow`

### Kitchen Renovations

Create a more functional, open and refined kitchen with coordinated cabinetry, countertops, lighting, flooring, plumbing and structural work.

Link label: **Explore Kitchen Renovations**

### Bathroom Renovations

Transform an outdated bathroom into a comfortable, durable space with thoughtful layouts, custom tile, vanities, showers and premium fixtures.

Link label: **Explore Bathroom Renovations**

### Basement Renovations

Turn underused square footage into a finished living area, entertainment space, home office, gym, guest suite or secondary dwelling.

Link label: **Explore Basement Renovations**

### Whole-Home Renovations

Rework layouts, finishes and building systems across the home through one coordinated renovation plan.

Link label: **Explore Whole-Home Renovations**

### Full-Gut Renovations

Strip an older or heavily dated property back to its structure and rebuild it for modern performance, function and style.

Link label: **Explore Full-Gut Renovations**

### Custom Homes

Build a one-of-a-kind home with MJL coordinating construction, trades, project sequencing and finishing details from the ground up.

Link label: **Explore Custom Homes**

---

# Section 5 — Featured project statement

## Layout

- Full width, split 55% image / 45% content
- Minimum height: 680px desktop
- Image flush to edges
- Content background: `#151515`
- Content padding: 88px

### Content

Eyebrow: **Built With Intention**

H2: **Every Detail Has a Job to Do**

Copy:

The strongest renovations balance appearance with everyday performance. Layout, storage, lighting, materials, mechanical systems and construction details should all work together—not compete for attention.

MJL approaches each project as a complete build, helping clients understand how individual choices affect cost, timing, maintenance and the finished result.

Button: **View Renovation Projects**

Link: `/renovation-projects/`

CSS class: `mjl-btn`

---

# Section 6 — Why MJL

## Container

- Background: white
- Padding: 112px 32px
- Boxed width

## Intro

Eyebrow: **Why Homeowners Choose MJL**

H2: **A More Organized Way to Renovate**

## Benefits

Use a 3x2 icon grid.

### Clear scope and expectations

We define the work, decisions and responsibilities before construction begins so there are fewer surprises later.

### Consistent communication

Clients receive practical updates and know who to contact when questions or decisions arise.

### Coordinated skilled trades

MJL manages the sequence of trades and keeps each phase moving toward the same finished standard.

### Respectful worksites

We plan access, protection and cleanup to reduce disruption and protect the parts of your home outside the work area.

### Quality-focused execution

Materials and details are installed for durability, clean appearance and long-term performance.

### Local accountability

MJL serves Burlington, Oakville, Waterdown and nearby communities with a reputation tied directly to the work we deliver.

---

# Section 7 — Process

## Background

`#EEEAE3`

## Header

Eyebrow: **Our Process**

H2: **A Clear Path From Idea to Completion**

## Five steps

Use numbered horizontal cards on desktop and stacked cards on mobile.

1. **Consultation** — Discuss the property, goals, priorities, timing and likely investment.
2. **Site Review** — Assess existing conditions, measurements, access and technical requirements.
3. **Scope & Planning** — Define the work, selections, allowances, schedule and next decisions.
4. **Construction** — Coordinate trades, materials, site activity and quality control.
5. **Final Walkthrough** — Review the completed work, resolve deficiencies and close out the project.

Button: **Explore the Full Process**

Link: `/renovation-process/`

---

# Section 8 — Project suitability / qualification

## Layout

Dark section with two columns.

### Left

Eyebrow: **Is MJL the Right Fit?**

H2: **Built for Homeowners Who Value the Process as Much as the Result**

### Right checklist

- You want a properly planned renovation, not a rushed patchwork job
- You value communication and clear expectations
- You are prepared to make informed material and design decisions
- You want one construction partner coordinating the work
- You care about durability, detail and long-term value

Footer note:

We will be direct when a budget, scope or timeline is not realistic. That honesty protects both the project and the client relationship.

---

# Section 9 — Service areas

## Header

Eyebrow: **Where We Work**

H2: **Renovations Across Halton and Hamilton**

Copy:

MJL Construction serves homeowners in Burlington, Oakville, Waterdown, Hamilton, Ancaster, Dundas, Milton, Flamborough and Stoney Creek.

Use a clean two-column list and a restrained local map graphic. Do not embed a heavy interactive map unless needed.

---

# Section 10 — FAQ

CSS class on Accordion widget: `mjl-faq`

## Questions and answers

### What types of renovation projects does MJL take on?

MJL focuses on kitchens, bathrooms, basements, whole-home renovations, full-gut transformations and custom homes. Project fit depends on scope, location, timing and the level of planning required.

### How early should we contact MJL?

Contact us as early as possible, particularly for larger renovations. Design decisions, pricing, permits, ordering and trade scheduling can require meaningful lead time before construction starts.

### Do you provide design services?

MJL can help coordinate the design and planning resources required for the project. The exact approach depends on the renovation scope and whether architectural, engineering, interior design or permit drawings are needed.

### Can we stay in the home during construction?

That depends on the work. Many kitchen, bathroom and basement projects can be completed while the home remains occupied, although there will be disruption. Whole-home and full-gut renovations may require temporary accommodation.

### Do renovation projects require permits?

Structural changes, plumbing relocations, new secondary units and many larger renovations may require permits. MJL will identify likely requirements during planning and coordinate the appropriate professionals where included in the scope.

### How much will our renovation cost?

Cost depends on the existing conditions, size, layout changes, materials, building systems and finish level. MJL provides project-specific guidance after understanding the property and intended scope rather than advertising misleading one-size-fits-all pricing.

### Which areas do you serve?

MJL serves Burlington, Oakville, Waterdown, Hamilton, Ancaster, Dundas, Milton, Flamborough and Stoney Creek.

---

# Section 11 — Consultation form

Anchor ID: `consultation`

## Layout

- Two columns: 42% content / 58% form
- Background: white
- Boxed width
- Padding: 112px 32px

### Left content

Eyebrow: **Start a Conversation**

H2: **Tell Us What You Are Planning**

Copy:

Share the basics of your property, the work you are considering and your preferred timing. MJL will review the information and follow up to discuss whether the project is a potential fit.

Contact details:

- 289-828-1933
- info@mjlconstruction.ca
- Inquiries accepted 24/7
- Consultations by appointment

### Form fields

1. Name — required
2. Email — required
3. Phone — required
4. Project address or postal code — required
5. Project type — required select
6. Conditional budget field based on project type
7. Preferred start timing — required select
8. Project description — required textarea
9. Photo upload — optional
10. Consent checkbox — required

Project type choices:

- Kitchen renovation
- Bathroom renovation
- Basement renovation
- Whole-home renovation
- Full-gut renovation
- Custom home
- Not sure yet

Timing choices:

- As soon as realistically possible
- Within 1–3 months
- Within 3–6 months
- Within 6–12 months
- More than 12 months away
- Researching only

Submit button: **Request My Consultation**

Destination: `info@mjlconstruction.ca`

Use Formidable Forms for conditional budget logic and file uploads.

---

# Section 12 — Footer CTA

Full-width charcoal section above the global footer.

H2: **Planning a Renovation in Burlington, Oakville or the Hamilton Area?**

Copy:

Start with a practical conversation about your home, goals and project scope.

Primary button: **Start Your Renovation**

Secondary text link: **Call 289-828-1933**

---

# SEO fields

## SEO title

Home Renovations Burlington, Oakville & Hamilton | MJL Construction

## Meta description

Plan your kitchen, bathroom, basement, whole-home renovation or custom home with MJL Construction. Serving Burlington, Oakville, Waterdown and the Hamilton area.

## Primary keyword

home renovations Burlington

## Supporting topics

- home renovations Oakville
- renovation contractor Waterdown
- home renovation Hamilton
- whole-home renovation contractor
- custom home builder Burlington

## Schema

- LocalBusiness through site-wide Yoast configuration
- Service schema where supported
- FAQ schema for the FAQ section
- Breadcrumb schema

---

# Mobile requirements

- Maintain at least 20px horizontal page gutters
- Stack all split layouts with copy before supporting images where appropriate
- Keep H1 near 40px, with no forced line breaks
- Buttons become full width when paired
- Do not autoplay background video on mobile
- Crop hero image to preserve the main architectural focal point
- Reduce large section padding to 64px
- Test all form selects and upload controls on iPhone and Android
