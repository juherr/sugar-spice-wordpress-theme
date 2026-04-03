# Sugar & Spice Migration Notes

## Summary

This theme has been modernized for current WordPress and PHP usage while preserving legacy behavior where practical.

The main architectural change is the move away from a monolithic `functions.php` and the start of a migration from the bundled Options Framework to the WordPress Customizer and native theme features.

## Refactored Structure

```text
functions.php
inc/
  admin.php
  bootstrap.php
  customizer.php
  enqueue.php
  extras.php
  helpers.php
  hooks.php
  jetpack.php
  setup.php
  template-tags.php
  widgets.php
  widgets/
    about-widget.php
    archives-widget.php
    contact-widget.php
    social-widget.php
js/
  theme.js
```

## What Changed

### Theme bootstrap

- `functions.php` now only bootstraps theme modules.
- Theme setup, widgets, assets, hooks, helpers, and admin integration are split into focused files under `inc/`.

### WordPress feature support

- Added support for `title-tag`.
- Added support for `custom-logo`.
- Added support for `responsive-embeds`.
- Added support for `wp-block-styles`.
- Added support for `align-wide`.
- Added support for `editor-styles`.
- Added `wp_body_open()` support in the header template.

### Assets

- Replaced inline footer JavaScript with `js/theme.js`.
- Theme scripts and styles now use versioning from the active theme version.
- Dynamic CSS is now injected with `wp_add_inline_style()` instead of raw `<style>` output.

### Widgets

- Removed `extract()` from custom widgets.
- Hardened escaping and sanitization.
- Preserved widget class names and registration to avoid breaking saved widget instances.

### Templates and helpers

- Removed legacy `wp_title()` usage.
- Hardened escaping in multiple templates.
- Replaced fragile legacy patterns like `$posts[0] == $post`.
- Removed all remaining `extract()` usage from the theme.

## Options Framework to Customizer Migration

### Current state

The old Options Framework runtime has been removed. Its admin page slug is redirected to the Customizer.

Legacy values are still read directly from the old option stored in the database while the new Customizer-based settings take precedence.

### Mapping

| Legacy option | New setting | Notes |
| --- | --- | --- |
| `main_color` | `theme_mod( 'main_color' )` | Select control |
| `accent_color` | `theme_mod( 'accent_color' )` | Select control |
| `hp_layout` | `theme_mod( 'hp_layout' )` | Select control |
| `ap_layout` | `theme_mod( 'ap_layout' )` | Select control |
| `responsive` | `theme_mod( 'disable_responsive' )` | Inverted boolean semantics |
| `meta_data['author']` | `theme_mod( 'display_post_meta_author' )` | Checkbox |
| `meta_data['date']` | `theme_mod( 'display_post_meta_date' )` | Checkbox |
| `meta_data['comments']` | `theme_mod( 'display_post_meta_comments' )` | Checkbox |
| `signature_image` | `theme_mod( 'signature_image_id' )` | Attachment ID when resolvable |
| `logo_image` | `custom_logo` | Native WordPress feature |
| `favicon` | `site_icon` | Native WordPress feature |

### Migration behavior

- Migration is idempotent.
- New Customizer values are only populated when a matching new value is not already present.
- Legacy settings continue to work as fallbacks.

### Limitation

Automatic migration of `logo_image`, `favicon`, and `signature_image` to native media-backed settings only works when the stored legacy URL matches an attachment known to the local WordPress media library.

If not, the theme continues to use the old value as a fallback.

## Backward Compatibility Notes

### Preserved

- Sidebar IDs
- Widget classes
- Theme option keys
- Public template filenames
- Existing frontend behavior where possible

### Potentially visible changes

- If both `custom_logo` and the old `logo_image` option exist, the native custom logo now takes priority.
- Social widget links now include `rel="noopener noreferrer"`.
- Signature images now use lazy loading.
- Legacy theme options UI is replaced by the Customizer.

## What Was Not Removed Yet

- Legacy option reads are still supported through helper fallbacks.

This is intentional to avoid breaking existing sites during the migration.

## Recommended Next Steps

1. Test the theme in a real WordPress 6.9 site with existing saved options.
2. Verify that migrated Customizer values appear correctly for upgraded installs.
3. Once upgrade behavior is confirmed, remove frontend fallback reads to legacy options.
