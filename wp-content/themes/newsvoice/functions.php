<?php
/**
 * NewsVoice theme setup.
 *
 * @package NewsVoice
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function newsvoice_asset_uri( string $path = '' ): string {
	return trailingslashit( get_template_directory_uri() ) . 'assets/' . ltrim( $path, '/' );
}

function newsvoice_setup(): void {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-logo', array( 'height' => 90, 'width' => 360, 'flex-height' => true, 'flex-width' => true ) );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'newsvoice' ),
			'footer'  => __( 'Footer Menu', 'newsvoice' ),
		)
	);
}
add_action( 'after_setup_theme', 'newsvoice_setup' );

function newsvoice_enqueue_assets(): void {
	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style(
		'newsvoice-fonts',
		'https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@400;500;600;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'newsvoice-theme',
		newsvoice_asset_uri( 'css/theme.css' ),
		array( 'newsvoice-fonts' ),
		$theme_version
	);

	wp_enqueue_script(
		'newsvoice-theme',
		newsvoice_asset_uri( 'js/theme.js' ),
		array(),
		$theme_version,
		true
	);

	wp_localize_script(
		'newsvoice-theme',
		'newsvoiceTheme',
		array(
			'assetBase' => newsvoice_asset_uri( 'media/' ),
			'demoBase'  => newsvoice_asset_uri( 'demo/' ),
			'articleUrl' => home_url( '/sample-article/' ),
			'homeUrl'   => home_url( '/' ),
			'homeBuilderEnabled' => function_exists( 'newsvoice_homepage_builder_get_settings' ) && ! empty( newsvoice_homepage_builder_get_settings()['enabled'] ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'newsvoice_enqueue_assets' );

function newsvoice_default_categories(): array {
	return array(
		'Sverige'      => 'sverige',
		'Världen'      => 'varlden',
		'Krig & Fred'  => 'krig-fred',
		'USA'          => 'usa',
		'Mellanöstern' => 'mellanostern',
		'Opinion'      => 'opinion',
		'Ekonomi'      => 'ekonomi',
		'Hälsa & Vård' => 'halsa-vard',
		'Media'        => 'media',
		'Kultur'       => 'kultur',
		'Teknik'       => 'teknik',
		'Vardagstips'  => 'vardagstips',
		'Engelska'     => 'engelska',
	);
}

function newsvoice_ensure_default_categories(): void {
	foreach ( newsvoice_default_categories() as $name => $slug ) {
		if ( term_exists( $slug, 'category' ) || term_exists( $name, 'category' ) ) {
			continue;
		}

		wp_insert_term(
			$name,
			'category',
			array(
				'slug' => $slug,
			)
		);
	}
}
add_action( 'after_switch_theme', 'newsvoice_ensure_default_categories' );
add_action( 'admin_init', 'newsvoice_ensure_default_categories' );

function newsvoice_show_all_post_categories_in_editor( array $args, int $post_id = 0 ): array {
	if ( 'category' !== ( $args['taxonomy'] ?? 'category' ) ) {
		return $args;
	}

	$args['hide_empty']    = false;
	$args['checked_ontop'] = false;

	return $args;
}
add_filter( 'wp_terms_checklist_args', 'newsvoice_show_all_post_categories_in_editor', 10, 2 );

function newsvoice_admin_editor_assets( string $hook_suffix ): void {
	if ( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}

	$screen = get_current_screen();
	if ( ! $screen || 'post' !== $screen->post_type ) {
		return;
	}

	wp_enqueue_style(
		'newsvoice-admin-editor',
		newsvoice_asset_uri( 'css/admin-editor.css' ),
		array(),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'admin_enqueue_scripts', 'newsvoice_admin_editor_assets' );

function newsvoice_body_classes( array $classes ): array {
	if ( is_front_page() && apply_filters( 'newsvoice_popup_enabled', false ) ) {
		$classes[] = 'splash-active';
	}

	return $classes;
}
add_filter( 'body_class', 'newsvoice_body_classes' );

function newsvoice_fallback_menu(): void {
	$items = array(
		'Hem' => home_url( '/' ),
	);

	foreach ( newsvoice_default_categories() as $label => $slug ) {
		$items[ $label ] = home_url( '/category/' . $slug . '/' );
	}

	echo '<ul class="menu">';
	foreach ( $items as $label => $url ) {
		printf(
			'<li class="menu-item"><a href="%s">%s</a></li>',
			esc_url( $url ),
			esc_html( $label )
		);
	}
	echo '</ul>';
}

function newsvoice_post_card( WP_Post $post, string $size = 'medium_large' ): void {
	$category = get_the_category( $post->ID );
	$label    = $category ? $category[0]->name : __( 'Nyheter', 'newsvoice' );
	$image    = get_the_post_thumbnail_url( $post->ID, $size );
	?>
	<a href="<?php echo esc_url( get_permalink( $post ) ); ?>" class="article-link">
		<div class="news-item-4">
			<div class="news-thumb">
				<?php if ( $image ) : ?>
					<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( get_the_title( $post ) ); ?>">
				<?php endif; ?>
				<span class="category-label"><?php echo esc_html( $label ); ?></span>
			</div>
			<h3><?php echo esc_html( get_the_title( $post ) ); ?></h3>
		</div>
	</a>
	<?php
}
