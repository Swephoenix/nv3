#!/usr/bin/env bash
set -euo pipefail

theme_dir="wp-content/themes/newsvoice"

required_files=(
  "$theme_dir/style.css"
  "$theme_dir/functions.php"
  "$theme_dir/header.php"
  "$theme_dir/footer.php"
  "$theme_dir/front-page.php"
  "$theme_dir/index.php"
  "$theme_dir/single.php"
  "$theme_dir/assets/css/theme.css"
  "$theme_dir/assets/js/theme.js"
)

for file in "${required_files[@]}"; do
  test -f "$file" || {
    echo "Missing required theme file: $file" >&2
    exit 1
  }
done

grep -q "Theme Name: NewsVoice" "$theme_dir/style.css"
grep -q "add_theme_support( 'post-thumbnails' )" "$theme_dir/functions.php"
grep -q "wp_enqueue_style" "$theme_dir/functions.php"
grep -q "fonts.googleapis.com" "$theme_dir/functions.php"
grep -q "Libre+Franklin" "$theme_dir/functions.php"
grep -q "Libre Franklin" "$theme_dir/assets/css/theme.css"
grep -q "wp_head()" "$theme_dir/header.php"
grep -q "! is_singular( 'post' )" "$theme_dir/header.php"
grep -q "id=\"current-date\"" "$theme_dir/header.php"
grep -q "wp_footer()" "$theme_dir/footer.php"
grep -q "have_posts()" "$theme_dir/index.php"
grep -q "the_content()" "$theme_dir/single.php"
grep -q "article-meta" "$theme_dir/single.php"
grep -q "article-share" "$theme_dir/single.php"
grep -q "share-facebook" "$theme_dir/single.php"
grep -q "share-wechat" "$theme_dir/single.php"
grep -q "share-toutiao" "$theme_dir/single.php"
grep -q "STATIC_ARTICLES" "$theme_dir/assets/js/theme.js"
