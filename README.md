# Sugar and Spice

- Theme URI: http://webtuts.pl/themes/sugar-spice
- Version: 2.0.0
- Requires at least: WordPress 3.6
- Tested up to: WordPress 4.0
- Author: Julien Herr
- Author URI: https://juherr.dev
- Original Author: Aleksandra Łączek
- Original Author URI: http://webtuts.pl/
- License: GNU General Public License v3.0
- License URI: http://www.gnu.org/licenses/gpl.html

## Contribution

This repository includes maintenance and contribution work by juherr.dev.

- Contributor: juherr.dev
- Contact: wordpress@juherr.dev
- Contribution year: 2026

## Copyright

Sugar and Spice WordPress Theme, Copyright 2014 Webtuts.pl

Additional repository maintenance and contribution work Copyright 2026 juherr.dev

The Sugar and Spice theme and all included images are distributed under the terms of the GNU GPL.

## Credits

Theme Sugar & Spice uses:

- Open Sans font (available through Google Web Fonts: http://www.google.com/webfonts/specimen/Open+Sans), licensed under Apache License Version 2 (http://www.apache.org/licenses/LICENSE-2.0.html)
- FlexSlider by WooThemes under the GPLv2 license (http://www.gnu.org/licenses/gpl-2.0.html)
- Genericons Icon Font by Automattic (http://automattic.com) licensed under the GPLv2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
- Modernizr (http://modernizr.com/) script licensed under MIT license (www.modernizr.com/license/)
- TinyNav script (http://tinynav.viljamis.com/) by Viljami Salminen licensed under MIT license

## Installation

You can install the theme through the WordPress installer under `Themes > Install themes` by searching for it.

Alternatively, download the file, unzip it, and move the unzipped contents to the `wp-content/themes` folder of your WordPress installation. You will then be able to activate the theme.

## Instructions

Theme Sugar & Spice offers custom Theme Options, which can be found under `Appearance > Theme Options`.

Theme customization options:

- Color scheme and accent color. The color scheme setting controls the color of links and buttons. Accent color changes ribbon color and widget title.
- Logo upload. You can upload your own image to serve as the website logo. If no image is uploaded, website title and description will be used instead. Max logo width: `1000px`.
- Favicon. You can upload your own custom favicon, which is the small `16px` by `16px` picture you see beside the URL in the browser address bar. The image should be named `favicon.ico`.
- Custom Background. You can set your own custom background using WordPress built-in background option (`Appearance > Background`).
- Layout options. You can choose from one of three ways of displaying blog posts on the home page. Categories and archives are always displayed as excerpts.
- Post meta display options. These refer to post information (date, author, comments) displayed below each post title on home page and categories/archive pages.
- Post signature image. You have the option to insert an image directly after post content. This can be your signature or anything else. Applies to all posts and accepts images only.

Sugar & Spice comes with a custom gallery, which replaces the standard WordPress image gallery with an image slideshow. You can still use tiled or other types of galleries that come with the Jetpack plugin.

If you wish to further customize the theme, use the My Custom CSS plugin (http://wordpress.org/plugins/my-custom-css/ for CSS only), or create a child theme.

If Sugar & Spice theme is activated on an existing website, it is highly recommended to regenerate post thumbnails using the Regenerate Thumbnails plugin (http://wordpress.org/plugins/regenerate-thumbnails/).

## Support

For questions, comments, or bug reports, please go to the WordPress forums: http://wordpress.org/support/

## Theme Features

- Multiple Color Schemes
- Custom Widgets
- Translation ready
- Drop-down Menus
- Cross-browser compatibility
- Threaded Comments
- Gravatar ready
- Theme Options
- 3 layout options

## Changelog

### 2.0.0 - 2026-04-03

- Modernized the theme bootstrap by splitting legacy setup logic into dedicated files under `inc/` and restoring a proper `index.php` fallback template
- Migrated legacy theme options to the WordPress Customizer with admin-side migration guidance documented in `MIGRATION.md`
- Removed the bundled Options Framework runtime and its legacy assets from the theme codebase
- Hardened templates, widgets, helpers, and enqueue logic for better compatibility with modern WordPress and current PHP expectations
- Standardized the codebase with a PHPCS baseline, Composer tooling, and a GitHub Actions workflow for automated coding standards checks
- Renamed `readme.txt` to `README.md`, updated theme metadata to version `2.0.0`, and added Julien Herr / juherr.dev contribution details

### 1.3.2 - 2014-10-03

- Removed saving theme options defaults to database
- Removed Pro upgrade notification
- Removed mini-thumb image size, as it is not actually used in the theme

### 1.3.1 - 2014-06-23

- Fixed slideshow gallery media link
- Fixed "First full rest as excerpts" option
- Added "Full width, No title" page template
- Added WooCommerce compatibility file
- Added styling for website input in comment form

### 1.3 - 2014-03-18

- Fixed bug when no post meta selected
- Added option to overwrite gallery slideshow in child theme
- Fixed author bio display
- Added option to disable responsive stylesheet
- Fixed issues with print styles
- Added option to choose archive page layout

### 1.2 - 2014-01-21

- Minor updates to Theme Options page

### 1.1 - 2014-01-13

- Fixed issue with background color implementation
- Fixed issue with non responsive custom logo
- Fixed issue with responsive images
- Fixed full width page template
- Updated social media widget, URLs now open in new window
- Added color to current menu item
- Updated theme tags
- Changed screenshot size

### 1.0 - 2013-11-20

- Initial release
