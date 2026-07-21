# MJL Renovations Coded Site

A custom-coded WordPress plugin for the renovation division of MJL Construction.

## What it does

- Leaves existing outdoor Elementor pages untouched.
- Creates draft renovation pages on activation.
- Uses a completely separate coded header, footer, typography and colour system.
- Registers an `MJL Projects` post type for portfolio entries.
- Lets editors update hero copy and image URLs through WordPress page fields.
- Uses the standard WordPress editor for each page's main content.
- Loads CSS and JavaScript only on renovation pages.
- Includes the approved MJL monogram inside the plugin.

## Installation

1. Download this repository.
2. Compress only `wordpress-plugin/mjl-renovations-coded`.
3. Upload the ZIP through **Plugins → Add New Plugin → Upload Plugin**.
4. Activate **MJL Renovations Coded Site**.
5. Go to **Pages** and preview the newly created drafts.
6. Edit hero fields in the `MJL Renovation Page Settings` box.
7. Edit the main body through the normal WordPress editor.
8. Add real portfolio work through **MJL Projects**.
9. Connect the Formidable form on the contact page before publishing.

## Important

- Deactivate the previous Elementor renovation builder and branding plugins.
- Do not publish until stock images are replaced with approved MJL photography where practical.
- The contact template currently expects a Formidable form with shortcode `[formidable id="contact"]`. Update the shortcode in `templates/page-renovations.php` to match the actual form ID.
- Pages are created as drafts and existing unmanaged pages are not deleted.
