# Repository Guidelines

## Project Structure & Module Organization

This repository contains a local NewsVoice WordPress build plus static reference pages. The custom theme lives in `wp-content/themes/newsvoice`; PHP templates are at the theme root, CSS is in `assets/css`, JavaScript is in `assets/js`, demos are in `assets/demo`, and imported media is in `assets/media`. The popup/splash plugin is in `wp-content/plugins/newsvoice-popup-manager`. Root-level HTML files are static comparison/demo pages. Shell tests are in `tests/`, and local tooling is in `tools/`.

## Build, Test, and Development Commands

- `docker compose up -d`: starts MariaDB and WordPress at `http://localhost:8081`, activates the `newsvoice` theme and popup plugin, and creates a sample article.
- `bash tests/theme_structure_test.sh`: verifies required theme files and core WordPress hooks.
- `bash tests/theme_admin_categories_test.sh`: checks the category editor behavior and related admin CSS.
- `bash tests/popup_plugin_test.sh`: checks popup registration, settings, rendering hooks, and that splash markup is not hardcoded in the theme.
- `./tools/phpcs wp-content/themes/newsvoice wp-content/plugins/newsvoice-popup-manager`: runs PHP_CodeSniffer via local PHP when possible, otherwise via Docker.

## Coding Style & Naming Conventions

Follow WordPress PHP style: tabs for indentation, snake_case function names prefixed with `newsvoice_` or `newsvoice_popup_`, strict comparisons, escaped output, sanitized settings, and early guard returns. Keep theme behavior in the theme and popup/splash controls in the plugin. Use kebab-case for CSS classes.

## Testing Guidelines

Tests are Bash smoke tests using `grep` and file checks. Name new tests by feature, for example `tests/header_navigation_test.sh`, and start them with `set -euo pipefail`. Run the relevant test plus adjacent tests before handing off changes. For PHP edits, also run `./tools/phpcs` on touched paths.

## Commit & Pull Request Guidelines

Recent commits use short imperative subjects such as `Update homepage demo content and navigation`, `Add homepage video splash screen`, and `Fix mobile navigation in article and index pages`. Keep subjects concise and behavior-focused. Pull requests should include a summary, commands run, linked issue/task, and screenshots for visible theme, popup, or responsive changes.

## Security & Configuration Tips

Do not commit production credentials. The Docker database credentials are local-only defaults in `docker-compose.yml`. In WordPress code, check capabilities for admin screens, sanitize saved options, escape rendered values, and use registered hooks instead of hardcoding page-specific markup when plugin settings should control behavior.
