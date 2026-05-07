#!/usr/bin/env bash
set -euo pipefail

plugin_dir="wp-content/plugins/newsvoice-popup-manager"
plugin_file="$plugin_dir/newsvoice-popup-manager.php"

test -f "$plugin_file" || {
  echo "Missing plugin file: $plugin_file" >&2
  exit 1
}

grep -q "Plugin Name: NewsVoice Popup Manager" "$plugin_file"
grep -q "add_menu_page" "$plugin_file"
grep -q "toplevel_page_newsvoice-popup-manager" "$plugin_file"
grep -q "register_setting" "$plugin_file"
grep -q "admin_enqueue_scripts" "$plugin_file"
grep -q "wp_body_open" "$plugin_file"
grep -q "newsvoice_popup_enabled" "$plugin_file"
grep -q "newsvoice_popup_render" "$plugin_file"
grep -q "newsvoice_popup_sanitize_settings" "$plugin_file"
grep -q "popup-admin.css" "$plugin_file"

test -f "$plugin_dir/assets/css/popup-admin.css" || {
  echo "Missing admin CSS file" >&2
  exit 1
}

if grep -q 'id="splash-screen"' wp-content/themes/newsvoice/front-page.php; then
  echo "Theme still hardcodes splash-screen markup" >&2
  exit 1
fi
