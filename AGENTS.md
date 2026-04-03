# AGENTS.md

## Purpose
This repository is a classic WordPress theme named `Sugar and Spice`.
Agents should treat it as a PHP/CSS/JS theme project, not as a Node, Composer, or framework app.
There is no in-repo build system, package manifest, or automated test suite.
Favor small, surgical edits that preserve existing theme behavior.

## Repository Facts
- Main entry point: `functions.php`
- Root templates are in the repository root; shared logic is in `inc/`; widgets are in `inc/widgets/`
- Theme options live in `options.php` and `inc/options-framework/`
- Frontend scripts live in `js/`; stylesheets are `style.css` and `responsive.css`
- Translation domain: `sugarspice`; theme prefix: `sugarspice_`

## Rules Files
No repository-local editor or Copilot rules were found: no `.cursor/rules/`, no `.cursorrules`, and no `.github/copilot-instructions.md`.
If any of those files are added later, update this document and follow them.

## Build Commands
There is no build step in this repository.
Do not invent `npm`, `pnpm`, `yarn`, `composer`, `vite`, or bundler commands unless corresponding config files are added.
Practical validation here means PHP syntax checks plus manual WordPress smoke testing.

Useful commands:
```bash
php -l functions.php
php -l inc/extras.php
php -l inc/template-tags.php
php -l inc/widgets/contact-widget.php
```

## Lint Commands
There is no lint config checked in.
Missing configs include `phpcs.xml`, `.phpcs.xml`, ESLint, Stylelint, and Prettier.

Baseline linting available in-repo:
```bash
php -l path/to/file.php
```

If `phpcs` is installed globally, it can be used as advisory linting for edited PHP files:
```bash
phpcs --standard=WordPress --extensions=php functions.php
phpcs --standard=WordPress --extensions=php inc/widgets/contact-widget.php
```
Treat PHPCS output as advisory unless a project config is added.

## Test Commands
There is no automated test suite in this repository.
The repo does not contain PHPUnit, Vitest, Jest, Playwright, Cypress, or a WordPress test bootstrap.
That means there is no true project-wide test command and no true single-test command.

Closest equivalents:
1. Single-file syntax check:
```bash
php -l path/to/file.php
```
2. Manual targeted verification in a local WordPress install:
- Load the affected template or admin screen with the theme active
- Reload and inspect frontend output
- Check PHP logs and browser console if relevant
3. If `wp` and a local WordPress install exist outside this repo, agents may use WP-CLI for smoke checks, but this repo does not define those commands.

## Recommended Verification Workflow
For PHP changes:
1. Run `php -l` on every edited PHP file.
2. Load the affected page in WordPress.
3. Re-check menus, widgets, comments, or theme options if touched.
4. Check escaping, translation, and markup regressions.

For CSS changes:
1. Refresh desktop and mobile layouts.
2. Check header, navigation, sidebar, widgets, posts, comments, and footer.
3. Confirm `responsive.css` still behaves correctly with the responsive option.

For JS changes:
1. Test in the browser.
2. Check the browser console.
3. Verify the changed behavior directly.

## Architecture Notes
This theme follows old-school WordPress theme conventions.
- Theme setup and hooks are centralized in `functions.php`
- Template helpers live in `inc/template-tags.php`; miscellaneous behavior lives in `inc/extras.php`
- Customizer logic lives in `inc/customizer.php`; theme options use the bundled options framework
- Widgets are class-based and registered in `functions.php`; some frontend behavior is emitted inline in `sugarspice_footer_js()`
Keep new code consistent with this structure unless the user asks for broader refactoring.

## Code Style Guidelines

### General
- Preserve existing WordPress theme conventions over introducing a new architecture.
- Prefer minimal edits in the file that already owns the behavior.
- Do not refactor unrelated legacy code just to modernize it, and leave vendored/minified assets alone unless targeted.

### PHP
- Use the existing `sugarspice_` prefix for new theme functions.
- Follow snake_case for functions and local variables.
- Existing widget class names use lowercase with underscores, e.g. `sugarspice_contact_widget`; preserve that local convention.
- Use guard clauses and early returns when conditions fail, and avoid broad whitespace-only diffs.
- Match the surrounding file's formatting instead of restyling the whole file.

### Imports And Includes
- There are no namespaces or PHP import statements in this codebase.
- Use `require` or `include` with `get_template_directory()` for theme-local files.
- Add includes in `functions.php` only when behavior truly belongs in a separate file.

### Formatting
- Keep brace and control-flow style consistent with the edited file.
- Avoid opportunistic reformatting.
- Preserve inline HTML/PHP template structure.
- Keep comments short and useful.

### Types
- This codebase is not typed and does not use strict typing.
- Do not add `declare(strict_types=1);`, typed properties, or heavy type abstractions unless explicitly requested.
- Use PHPDoc only when it materially clarifies a callback, parameter, or return value.

### Naming
- Prefix new theme functions with `sugarspice_`.
- Use descriptive snake_case names and match WordPress naming for hooks, callbacks, and template concepts.
- Avoid new abbreviations unless nearby code already uses them.

### WordPress Conventions
- Use WordPress hooks instead of ad hoc execution when extending behavior.
- Wrap pluggable functions in `function_exists()` only where the theme already follows that pattern.
- Use core APIs for menus, sidebars, widgets, translations, escaping, and theme support, and respect the `sugarspice` text domain.

### Escaping, Sanitization, And I18n
- Escape output as late as possible with the proper helper: `esc_html()`, `esc_attr()`, `esc_url()`, etc.
- Sanitize widget and option values before persisting them.
- Follow existing WordPress patterns when outputting attributes, URLs, and content.
- Wrap new visible strings in translation helpers like `__()`, `_e()`, or `_x()` using `sugarspice`.

### Error Handling
- Prefer defensive checks over exception-based patterns.
- Check optional WordPress state before using it, return early for invalid context, and do not suppress errors unless matching existing theme patterns.

### JavaScript
- JS here is plain browser JavaScript and jQuery, not modules.
- Preserve the existing IIFE style and current jQuery usage.
- Do not introduce bundler-dependent patterns or new dependencies.
- Keep changes targeted to the existing theme behavior.

### CSS
- Keep changes in `style.css` or `responsive.css` unless there is a strong reason otherwise.
- Preserve the stylesheet's sectioned organization, avoid renaming public classes without updating templates, and check both desktop and mobile behavior.

## Change Management
- Treat this as a legacy theme with production-like behavior expectations.
- Backward compatibility matters more than stylistic purity.
- Avoid changing markup structure unless the task requires it.
- Be careful with hooks, widget IDs, option keys, text domains, and template filenames.
- If a change affects public markup or saved options, verify the impact before expanding scope.

## Commit Messages
- When creating commits, follow the Conventional Commits 1.0.0 format: `type(scope): description` when a scope is useful, or `type: description` otherwise.
- Prefer standard types such as `feat`, `fix`, `docs`, `refactor`, `test`, `build`, `ci`, `chore`, and `perf`.
- Keep commit subjects concise, imperative, and lowercase unless a proper noun requires capitalization.
- Reference: `https://www.conventionalcommits.org/en/v1.0.0/`

## Final Response Expectations
When reporting work, include:
1. Which files changed
2. What behavior changed
3. Which validation steps you ran
4. What you could not verify because the repo lacks automation
