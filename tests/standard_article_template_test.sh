#!/usr/bin/env bash
set -euo pipefail

template_file="wp-content/themes/newsvoice/template-standard_article.php"

test -f "$template_file" || {
	echo "Missing standard article template: $template_file" >&2
	exit 1
}

grep -q "Template Name: standard_article" "$template_file"
grep -q "get_header()" "$template_file"
grep -q "get_footer()" "$template_file"
grep -q "top-split-layout" "$template_file"
grep -q "breadcrumbs" "$template_file"
grep -q "article-share" "$template_file"
grep -q "share-facebook" "$template_file"
grep -q "share-x" "$template_file"
grep -q "share-linkedin" "$template_file"
grep -q "share-wechat" "$template_file"
grep -q "share-weibo" "$template_file"
grep -q "share-douyin" "$template_file"
grep -q "share-toutiao" "$template_file"
grep -q "article-meta" "$template_file"
grep -q "Publicerad" "$template_file"
grep -q "article-hero" "$template_file"
grep -q "newsvoice_article_ingress" "$template_file"
grep -q "article-ingress" "$template_file"
grep -q "the_content()" "$template_file"
grep -q "get_the_post_thumbnail" "$template_file"
grep -q "sidebar" "$template_file"
grep -q "esc_url( get_permalink() )" "$template_file"
grep -q "rawurlencode( get_the_title() )" "$template_file"

theme_css="wp-content/themes/newsvoice/assets/css/theme.css"

grep -q ".breadcrumbs" "$theme_css"
grep -q ".article-dek" "$theme_css"
grep -q ".article-meta" "$theme_css"
grep -q ".article-share" "$theme_css"
grep -q ".share-btn" "$theme_css"
grep -q ".share-wechat" "$theme_css"
grep -q ".share-douyin" "$theme_css"
grep -q ".share-toutiao" "$theme_css"
grep -q ".article-hero-caption" "$theme_css"
grep -q ".article-end" "$theme_css"
grep -q ".article-author-card" "$theme_css"
grep -q ".news-timeline-list" "$theme_css"
