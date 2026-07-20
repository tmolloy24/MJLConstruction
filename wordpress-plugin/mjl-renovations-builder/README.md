# MJL Renovations Elementor Builder

This WordPress plugin creates the full MJL renovation page set as Elementor-compatible draft pages.

## Install the plugin

1. Download the repository from GitHub using **Code → Download ZIP**.
2. Unzip the downloaded repository on your computer.
3. Open `wordpress-plugin`.
4. Right-click or compress the `mjl-renovations-builder` folder into a new ZIP file. The ZIP must contain the plugin folder and be named `mjl-renovations-builder.zip`.
5. In WordPress, go to **Plugins → Add New Plugin → Upload Plugin**.
6. Upload `mjl-renovations-builder.zip`.
7. Click **Install Now**, then **Activate**.
8. Go to **Tools → MJL Renovations Builder**.
9. Click **Build or Refresh Renovation Pages**.
10. Go to **Pages → All Pages**. All generated pages are saved as drafts.

## Pages created

- Home Renovations
- Kitchen Renovations
- Bathroom Renovations
- Basement Renovations
- Whole Home Renovations
- Custom Home Building
- Our Renovation Process
- Renovation Portfolio
- Renovation Financing
- About MJL Renovations
- Client Reviews
- Start Your Renovation

## Review order

1. Preview **Home Renovations** first.
2. Preview the five service pages.
3. Preview Process, About and Contact.
4. Replace the image placeholders and review placeholders.
5. Replace the starter email form with Formidable Forms before publishing.
6. Add the approved pages to the WordPress navigation.
7. Change the page template from Elementor Canvas only after deciding whether to use the plugin header or the existing Astra header.
8. Test all links and submit a test lead on desktop and mobile.

## Important safeguards

- Generated pages are drafts.
- The plugin will not overwrite a page it did not create.
- Running the builder again refreshes only plugin-managed pages.
- Stock hero imagery is temporary and should be replaced with authentic or properly licensed MJL imagery.
- Review placeholders must be replaced with verified client reviews.
- Financing claims should not be published until MJL has an approved financing provider.

## Formidable Forms replacement

Create a Formidable form with these fields:

- Name
- Email
- Phone
- Project city or postal code
- Project type
- Estimated investment
- Desired start date
- Project details
- Photo upload
- Consent checkbox

Set the notification recipient to `info@mjlconstruction.ca`. Replace the starter form markup on the Contact page with the Formidable shortcode after testing email delivery and entry storage.