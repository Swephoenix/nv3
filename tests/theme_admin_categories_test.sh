#!/usr/bin/env bash
set -euo pipefail

theme_dir="wp-content/themes/newsvoice"
functions_file="$theme_dir/functions.php"
admin_css="$theme_dir/assets/css/admin-editor.css"

test -f "$functions_file" || {
  echo "Missing theme functions file" >&2
  exit 1
}

grep -q "newsvoice_show_all_post_categories_in_editor" "$functions_file"
grep -q "wp_terms_checklist_args" "$functions_file"
grep -Fq "\$args['hide_empty']    = false" "$functions_file"
grep -Fq "\$args['checked_ontop'] = false" "$functions_file"
grep -q "newsvoice_default_categories" "$functions_file"
grep -q "newsvoice_ensure_default_categories" "$functions_file"
grep -q "term_exists" "$functions_file"
grep -q "wp_insert_term" "$functions_file"
grep -q "after_switch_theme" "$functions_file"
grep -q "admin_init" "$functions_file"
grep -q "'Sverige'" "$functions_file"
grep -q "'Världen'" "$functions_file"
grep -q "'Krig & Fred'" "$functions_file"
grep -q "'Hälsa & Vård'" "$functions_file"
grep -q "foreach ( newsvoice_default_categories() as \$label => \$slug )" "$functions_file"
grep -q "home_url( '/category/' . \$slug . '/' )" "$functions_file"
grep -q "newsvoice_admin_editor_assets" "$functions_file"
grep -q "admin_enqueue_scripts" "$functions_file"
grep -q "css/admin-editor.css" "$functions_file"

test -f "$admin_css" || {
  echo "Missing admin editor CSS" >&2
  exit 1
}

grep -q ".editor-post-taxonomies__hierarchical-terms-list" "$admin_css"
grep -q "#category-all" "$admin_css"
