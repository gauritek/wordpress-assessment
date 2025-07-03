# WordPress Customizations

This repository/document contains details of customizations made to a WordPress website, including themes, plugins, and custom code based on doc file.

---

## Environment

- **WordPress Version:** 6.8.1
- **PHP Version:** 8.1
- **Web Server:** Apache/Nginx
- **Theme:** Twenty Twenty Four
- **Child Theme:** Yes 
--

## Theme Customizations

### Child Theme

- Created a child theme for safe updates.
- Location: `/wp-content/themes/twentytwentyfour-child`
- Customizations:
  - Modified header layout
  - Custom footer template
  - Additional CSS for styling adjustments

### Templates

- Custom template files:
  - `archive-project.php`
  - `web-config.php`

---

Example:

- **Advanced Custom Fields (ACF):**
  - Added custom fields for Projects CPT
  - JSON sync enabled for portability

---

## Custom Post Types & Taxonomies

- **Custom Post Types:**
  - `Projects` — supports title, editor, thumbnail
  - `Team Members` — supports title, custom fields

- **Custom Taxonomies:**
  - `Project Type` linked to `Projects` CPT
  - Hierarchical/Non-hierarchical

---

## Custom Code

### Functions.php

- Added custom functions:
  - Custom Post Type Extension
  - WooCommerce Checkout Improvement
  - WP Cron Review
  - Add REST API Endpoint
  - Security Audit (Quick)


## Cron Jobs

- Custom cron job to:
  - Set expired posts to draft
  - List all the crons which are running

## Important Links

- Main website - https://nirmal-wordpress.byethost22.com/
- Admin Url - https://nirmal-wordpress.byethost22.com/wp-login.php
- Credentials- admin/Test@123#
- Rest API Endpoint - https://nirmal-wordpress.byethost22.com/wp-json/custom/v1/latest-posts/
- Github Url - https://github.com/gauritek/wordpress-assessment

