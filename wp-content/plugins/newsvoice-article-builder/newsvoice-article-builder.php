<?php
/**
 * Plugin Name: NewsVoice Article Builder
 * Description: Adds structured article fields with a live preview for the NewsVoice standard article template.
 * Version: 1.0.0
 * Author: NewsVoice
 * Text Domain: newsvoice-article-builder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const NEWSVOICE_ARTICLE_BUILDER_VERSION = '1.0.0';
const NEWSVOICE_ARTICLE_BUILDER_TEMPLATE = 'template-standard_article.php';

function newsvoice_article_builder_meta_keys(): array {
	return array(
		'article_kicker'              => 'text',
		'newsvoice_article_dek'       => 'textarea',
		'newsvoice_article_ingress'   => 'textarea',
		'newsvoice_hero_image_url'    => 'url',
		'newsvoice_hero_caption'      => 'textarea',
		'newsvoice_sources'           => 'textarea',
		'newsvoice_support_image_id'  => 'image',
		'newsvoice_support_image_url' => 'url',
		'newsvoice_support_url'       => 'url',
		'newsvoice_medialinq_image_id' => 'image',
		'newsvoice_medialinq_image_url' => 'url',
		'newsvoice_medialinq_url'     => 'url',
		'newsvoice_banner_image_id'   => 'image',
		'newsvoice_banner_image_url'  => 'url',
		'newsvoice_banner_url'        => 'url',
	);
}

function newsvoice_article_builder_default_asset_url( string $path ): string {
	return get_template_directory_uri() . '/assets/media/' . ltrim( $path, '/' );
}

function newsvoice_article_builder_default_article(): array {
	return array(
		'title'        => 'Israels och USA:s krig mot Iran: Vad som har hänt och hur konflikten trappats upp',
		'category'     => 'Krig & Fred',
		'kicker'       => 'Analys',
		'dek'          => 'En sammanfattande genomgång av hur angrepp, motangrepp, regional press och stormaktspolitik har fört konflikten mellan Israel, USA och Iran in i en farligare fas.',
		'hero_image_url' => newsvoice_article_builder_default_asset_url( 'NewsVoice - Public Service på riktigt_files/Iran-armada-1170x600.jpg' ),
		'hero_caption' => 'Bild: Militär upptrappning kring Iran i en konflikt som successivt gått från skuggkrig till mer öppna konfrontationer.',
		'ingress'      => 'Konflikten mellan Israel, USA och Iran har under lång tid byggts upp genom skuggkrig, sanktioner, cyberoperationer, attacker mot ombudsstyrkor och återkommande hot om direkt konfrontation. Det som tidigare utspelade sig genom proxygrupper och begränsade militära markeringar har steg för steg blivit en öppnare och mer riskfylld konflikt.',
		'content'      => '<p>Israel har motiverat sina operationer med att Irans regionala nätverk, robotprogram och militära uppbyggnad utgör ett existentiellt hot. USA har samtidigt fördjupat sitt militära och diplomatiska stöd till Israel, först genom avskräckning och försvarssystem, därefter genom en hårdare linje mot iranska mål, iransk infrastruktur och iranskt inflytande i regionen.</p><p>Iran har i sin tur svarat med hot om vedergällning, mobilisering av allierade aktörer och signaler om att varje direkt angrepp kommer att få konsekvenser långt utanför landets gränser. Därmed har konflikten inte bara handlat om Iran, utan om hela maktbalansen i Mellanöstern: Persiska viken, Irak, Syrien, Libanon, Röda havet och internationella handelsleder.</p>',
		'sources'      => "https://newsvoice.se/ | NewsVoice | samlad bevakning av geopolitik, Mellanöstern och krigsutvecklingen i regionen.\nhttps://x.com/ | Öppna källor och officiella uttalanden | pressmeddelanden, tal och militära markeringar från berörda parter.\nhttps://newsvoice.se/category/krig-overvakning/ | NewsVoice / Krig & Fred | bakgrundstexter om regional upptrappning, proxykrig och stormaktsintressen.",
		'support_image_url' => newsvoice_article_builder_default_asset_url( 'NVannons.png' ),
		'support_url'  => 'https://newsvoice.se/donera/',
		'medialinq_image_url' => newsvoice_article_builder_default_asset_url( 'kaffeannons.png' ),
		'medialinq_url' => 'https://newsvoice.se/donera/',
		'banner_image_url' => newsvoice_article_builder_default_asset_url( 'NewsVoice - Public Service på riktigt_files/annonsera-i-newsvoice.jpg' ),
		'banner_url'   => 'https://newsvoice.se/2026/01/annonsera-i-newsvoice-2/',
	);
}

function newsvoice_article_builder_get_value( int $post_id, string $key ): string {
	return (string) get_post_meta( $post_id, $key, true );
}

function newsvoice_article_builder_split_ingress_from_content( string $content ): array {
	$pattern = '/<p\b(?=[^>]*class=(["\'])(?:(?!\1).)*\barticle-ingress\b(?:(?!\1).)*\1)[^>]*>(.*?)<\/p>/is';

	if ( preg_match( $pattern, $content, $matches ) ) {
		$stripped_content = trim( preg_replace( $pattern, '', $content, 1 ) ?? $content );

		return array(
			'ingress' => trim( wp_strip_all_tags( $matches[2] ) ),
			'content' => $stripped_content,
		);
	}

	return array(
		'ingress' => '',
		'content' => $content,
	);
}

function newsvoice_article_builder_add_meta_box(): void {
	add_meta_box(
		'newsvoice-article-builder',
		__( 'NewsVoice Artikelbyggare', 'newsvoice-article-builder' ),
		'newsvoice_article_builder_render_meta_box',
		'post',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'newsvoice_article_builder_add_meta_box' );

function newsvoice_article_builder_admin_menu(): void {
	add_menu_page(
		__( 'NewsVoice Artikelbyggare', 'newsvoice-article-builder' ),
		__( 'NewsVoice Artikelbyggare', 'newsvoice-article-builder' ),
		'edit_posts',
		'newsvoice-article-builder',
		'newsvoice_article_builder_render_admin_page',
		'dashicons-media-document',
		5
	);

	add_submenu_page(
		'newsvoice-article-builder',
		__( 'Ny artikel', 'newsvoice-article-builder' ),
		__( 'Ny artikel', 'newsvoice-article-builder' ),
		'edit_posts',
		'newsvoice-article-builder',
		'newsvoice_article_builder_render_admin_page'
	);
}
add_action( 'admin_menu', 'newsvoice_article_builder_admin_menu' );

function newsvoice_article_builder_admin_assets( string $hook_suffix ): void {
	if ( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php', 'toplevel_page_newsvoice-article-builder' ), true ) ) {
		return;
	}

	$screen = get_current_screen();
	if ( ! $screen || ( 'post' !== $screen->post_type && 'toplevel_page_newsvoice-article-builder' !== $hook_suffix ) ) {
		return;
	}

	wp_enqueue_media();

	wp_enqueue_style(
		'newsvoice-article-builder-admin',
		plugins_url( 'assets/css/newsvoice-article-builder-admin.css', __FILE__ ),
		array(),
		NEWSVOICE_ARTICLE_BUILDER_VERSION
	);

	wp_enqueue_script(
		'newsvoice-article-builder-admin',
		plugins_url( 'assets/js/newsvoice-article-builder-admin.js', __FILE__ ),
		array( 'jquery' ),
		NEWSVOICE_ARTICLE_BUILDER_VERSION,
		true
	);
}
add_action( 'admin_enqueue_scripts', 'newsvoice_article_builder_admin_assets' );

function newsvoice_article_builder_image_control( int $post_id, string $key, string $label, string $default_url = '', string $url_key = '' ): void {
	$image_id  = absint( get_post_meta( $post_id, $key, true ) );
	$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : $default_url;
	?>
	<div class="nv-article-builder-image" data-image-control="<?php echo esc_attr( $key ); ?>">
		<label><?php echo esc_html( $label ); ?></label>
		<input type="hidden" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $image_id ); ?>" data-preview-field="<?php echo esc_attr( $key ); ?>">
		<?php if ( $url_key ) : ?>
			<input type="hidden" name="<?php echo esc_attr( $url_key ); ?>" value="<?php echo esc_attr( $default_url ); ?>">
		<?php endif; ?>
		<div class="nv-article-builder-image__preview">
			<?php if ( $image_url ) : ?>
				<img src="<?php echo esc_url( $image_url ); ?>" alt="">
			<?php else : ?>
				<span><?php esc_html_e( 'Ingen bild vald', 'newsvoice-article-builder' ); ?></span>
			<?php endif; ?>
		</div>
		<button type="button" class="button nv-article-builder-select-image" data-target="<?php echo esc_attr( $key ); ?>"><?php esc_html_e( 'Välj bild', 'newsvoice-article-builder' ); ?></button>
		<button type="button" class="button-link nv-article-builder-remove-image" data-target="<?php echo esc_attr( $key ); ?>"><?php esc_html_e( 'Ta bort', 'newsvoice-article-builder' ); ?></button>
	</div>
	<?php
}

function newsvoice_article_builder_render_meta_box( WP_Post $post ): void {
	wp_nonce_field( 'newsvoice_article_builder_save', 'newsvoice_article_builder_nonce' );

	$kicker       = newsvoice_article_builder_get_value( $post->ID, 'article_kicker' );
	$dek          = newsvoice_article_builder_get_value( $post->ID, 'newsvoice_article_dek' );
	$article_ingress = newsvoice_article_builder_get_value( $post->ID, 'newsvoice_article_ingress' );
	$hero_caption = newsvoice_article_builder_get_value( $post->ID, 'newsvoice_hero_caption' );
	$sources      = newsvoice_article_builder_get_value( $post->ID, 'newsvoice_sources' );
	?>
	<div class="nv-article-builder">
		<div class="nv-article-builder__fields">
			<div class="nv-article-builder-card">
				<h3><?php esc_html_e( 'Artikelhuvud', 'newsvoice-article-builder' ); ?></h3>
				<label for="nv-article-kicker"><?php esc_html_e( 'Etikett / kicker', 'newsvoice-article-builder' ); ?></label>
				<input id="nv-article-kicker" class="widefat" type="text" name="article_kicker" value="<?php echo esc_attr( $kicker ); ?>" placeholder="Analys" data-preview-field="kicker">

				<label for="nv-article-dek"><?php esc_html_e( 'Ingress under rubrik', 'newsvoice-article-builder' ); ?></label>
				<textarea id="nv-article-dek" class="widefat" rows="3" name="newsvoice_article_dek" data-preview-field="dek"><?php echo esc_textarea( $dek ); ?></textarea>

				<label for="nv-article-ingress"><?php esc_html_e( 'Ingress i artikeltext', 'newsvoice-article-builder' ); ?></label>
				<textarea id="nv-article-ingress" class="widefat" rows="4" name="newsvoice_article_ingress" data-preview-field="article_ingress"><?php echo esc_textarea( $article_ingress ); ?></textarea>

				<label for="nv-hero-caption"><?php esc_html_e( 'Bildtext till utvald bild', 'newsvoice-article-builder' ); ?></label>
				<textarea id="nv-hero-caption" class="widefat" rows="2" name="newsvoice_hero_caption" data-preview-field="hero_caption"><?php echo esc_textarea( $hero_caption ); ?></textarea>
			</div>

			<div class="nv-article-builder-card">
				<h3><?php esc_html_e( 'Källor och slutsektioner', 'newsvoice-article-builder' ); ?></h3>
				<label for="nv-sources"><?php esc_html_e( 'Källor', 'newsvoice-article-builder' ); ?></label>
				<textarea id="nv-sources" class="widefat" rows="5" name="newsvoice_sources" data-preview-field="sources" placeholder="En källa per rad. Exempel: https://newsvoice.se/ | NewsVoice | Samlad bevakning"><?php echo esc_textarea( $sources ); ?></textarea>

				<?php newsvoice_article_builder_image_control( $post->ID, 'newsvoice_support_image_id', __( 'Stödannons', 'newsvoice-article-builder' ) ); ?>
				<label for="nv-support-url"><?php esc_html_e( 'Länk för stödannons', 'newsvoice-article-builder' ); ?></label>
				<input id="nv-support-url" class="widefat" type="url" name="newsvoice_support_url" value="<?php echo esc_attr( newsvoice_article_builder_get_value( $post->ID, 'newsvoice_support_url' ) ); ?>" placeholder="https://newsvoice.se/donera/">

				<?php newsvoice_article_builder_image_control( $post->ID, 'newsvoice_medialinq_image_id', __( 'Medialinq-bild', 'newsvoice-article-builder' ) ); ?>
				<label for="nv-medialinq-url"><?php esc_html_e( 'Länk för Medialinq', 'newsvoice-article-builder' ); ?></label>
				<input id="nv-medialinq-url" class="widefat" type="url" name="newsvoice_medialinq_url" value="<?php echo esc_attr( newsvoice_article_builder_get_value( $post->ID, 'newsvoice_medialinq_url' ) ); ?>" placeholder="https://newsvoice.se/donera/">

				<?php newsvoice_article_builder_image_control( $post->ID, 'newsvoice_banner_image_id', __( 'Banner längst ned', 'newsvoice-article-builder' ) ); ?>
				<label for="nv-banner-url"><?php esc_html_e( 'Länk för banner', 'newsvoice-article-builder' ); ?></label>
				<input id="nv-banner-url" class="widefat" type="url" name="newsvoice_banner_url" value="<?php echo esc_attr( newsvoice_article_builder_get_value( $post->ID, 'newsvoice_banner_url' ) ); ?>" placeholder="https://newsvoice.se/annonsera/">
			</div>
		</div>

		<?php newsvoice_article_builder_render_preview( $post->ID, $post ); ?>
	</div>
	<?php
}

function newsvoice_article_builder_get_edit_post(): ?WP_Post {
	$post_id = isset( $_GET['post_id'] ) ? absint( $_GET['post_id'] ) : 0;
	if ( ! $post_id ) {
		return null;
	}

	$post = get_post( $post_id );
	if ( ! $post || 'post' !== $post->post_type || ! current_user_can( 'edit_post', $post_id ) ) {
		return null;
	}

	return $post;
}

function newsvoice_article_builder_render_admin_page(): void {
	if ( ! current_user_can( 'edit_posts' ) ) {
		wp_die( esc_html__( 'Du har inte behörighet att skapa artiklar.', 'newsvoice-article-builder' ) );
	}

	$post         = newsvoice_article_builder_get_edit_post();
	$defaults     = newsvoice_article_builder_default_article();
	$post_id      = $post ? (int) $post->ID : 0;
	$title        = $post ? $post->post_title : $defaults['title'];
	$content      = $post ? $post->post_content : $defaults['content'];
	$article_ingress = $post_id ? newsvoice_article_builder_get_value( $post_id, 'newsvoice_article_ingress' ) : ( $defaults['ingress'] ?? '' );
	if ( ! $article_ingress ) {
		$split_content   = newsvoice_article_builder_split_ingress_from_content( $content );
		$article_ingress = $split_content['ingress'];
		$content         = $split_content['content'];
	}
	$status       = $post ? $post->post_status : 'draft';
	$thumbnail_id = $post_id ? (int) get_post_thumbnail_id( $post_id ) : 0;
	$category_ids = $post_id ? wp_get_post_categories( $post_id ) : array();
	$selected_cat = $category_ids ? (int) $category_ids[0] : 0;
	if ( ! $selected_cat ) {
		$default_category = get_category_by_slug( 'krig-fred' );
		$selected_cat     = $default_category ? (int) $default_category->term_id : 0;
	}
	$preview_link = $post_id ? get_preview_post_link( $post_id ) : '';
	$edit_link    = $post_id ? get_edit_post_link( $post_id, '' ) : '';
	?>
	<div class="wrap nv-article-builder-page">
		<h1><?php esc_html_e( 'NewsVoice Artikelbyggare', 'newsvoice-article-builder' ); ?></h1>

		<?php if ( isset( $_GET['saved'] ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Artikeln sparades.', 'newsvoice-article-builder' ); ?></p></div>
		<?php endif; ?>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="newsvoice_article_builder_save">
			<input type="hidden" name="post_id" value="<?php echo esc_attr( $post_id ); ?>">
			<?php wp_nonce_field( 'newsvoice_article_builder_form_save', 'newsvoice_article_builder_form_nonce' ); ?>

			<div class="nv-article-builder-page__toolbar">
				<button type="submit" class="button button-primary nv-article-builder-save-top">
					<?php esc_html_e( 'Spara artikel', 'newsvoice-article-builder' ); ?>
				</button>
			</div>

			<div class="nv-article-builder">
				<div class="nv-article-builder__fields">
					<?php newsvoice_article_builder_render_field_cards( $post_id, $defaults, 'header' ); ?>

					<div class="nv-article-builder-card">
						<h2><?php esc_html_e( 'Artikel', 'newsvoice-article-builder' ); ?></h2>

						<label for="nv-article-title"><?php esc_html_e( 'Rubrik', 'newsvoice-article-builder' ); ?></label>
						<input id="nv-article-title" class="widefat" type="text" name="post_title" value="<?php echo esc_attr( $title ); ?>" data-preview-field="title" required>

						<label for="nv-article-category"><?php esc_html_e( 'Kategori', 'newsvoice-article-builder' ); ?></label>
						<?php
						wp_dropdown_categories(
							array(
								'hide_empty'         => false,
								'hierarchical'       => true,
								'name'               => 'newsvoice_article_category',
								'id'                 => 'nv-article-category',
								'class'              => 'widefat',
								'selected'           => $selected_cat,
								'show_option_none'   => __( 'Välj kategori', 'newsvoice-article-builder' ),
								'option_none_value'  => 0,
							)
						);
						?>

						<label for="nv-article-status"><?php esc_html_e( 'Status', 'newsvoice-article-builder' ); ?></label>
						<select id="nv-article-status" class="widefat" name="post_status">
							<option value="draft" <?php selected( $status, 'draft' ); ?>><?php esc_html_e( 'Utkast', 'newsvoice-article-builder' ); ?></option>
							<option value="publish" <?php selected( $status, 'publish' ); ?>><?php esc_html_e( 'Publicerad', 'newsvoice-article-builder' ); ?></option>
						</select>

						<label for="nv-article-ingress"><?php esc_html_e( 'Ingress i artikeltext', 'newsvoice-article-builder' ); ?></label>
						<textarea id="nv-article-ingress" class="widefat" rows="4" name="newsvoice_article_ingress" data-preview-field="article_ingress"><?php echo esc_textarea( $article_ingress ); ?></textarea>

						<label for="nv_article_content"><?php esc_html_e( 'Artikeltext', 'newsvoice-article-builder' ); ?></label>
						<div class="nv-article-builder-editor">
							<?php
							wp_editor(
								$content,
								'nv_article_content',
								array(
									'textarea_name' => 'post_content',
									'textarea_rows' => 12,
									'media_buttons' => false,
									'quicktags'     => false,
									'teeny'         => true,
									'wpautop'       => true,
									'tinymce'       => array(
										'toolbar1'      => 'bold italic removeformat undo redo',
										'toolbar2'      => '',
										'block_formats' => __( 'Stycke=p', 'newsvoice-article-builder' ),
									),
								)
							);
							?>
						</div>

						<?php newsvoice_article_builder_image_control( $post_id, '_thumbnail_id', __( 'Utvald bild', 'newsvoice-article-builder' ), $post_id ? newsvoice_article_builder_get_value( $post_id, 'newsvoice_hero_image_url' ) : $defaults['hero_image_url'], 'newsvoice_hero_image_url' ); ?>
					</div>

					<?php newsvoice_article_builder_render_field_cards( $post_id, $defaults, 'end' ); ?>

					<p class="submit">
						<button type="submit" class="button button-primary"><?php esc_html_e( 'Spara artikel', 'newsvoice-article-builder' ); ?></button>
						<?php if ( $preview_link ) : ?>
							<a class="button" href="<?php echo esc_url( $preview_link ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Förhandsgranska', 'newsvoice-article-builder' ); ?></a>
						<?php endif; ?>
						<?php if ( $edit_link ) : ?>
							<a class="button-link" href="<?php echo esc_url( $edit_link ); ?>"><?php esc_html_e( 'Öppna i WordPress-redigeraren', 'newsvoice-article-builder' ); ?></a>
						<?php endif; ?>
					</p>
				</div>

				<?php newsvoice_article_builder_render_preview( $post_id, $post, $defaults ); ?>
			</div>
		</form>
	</div>
	<?php
}

function newsvoice_article_builder_render_field_cards( int $post_id, array $defaults = array(), string $section = 'all' ): void {
	$kicker       = $post_id ? newsvoice_article_builder_get_value( $post_id, 'article_kicker' ) : ( $defaults['kicker'] ?? '' );
	$dek          = $post_id ? newsvoice_article_builder_get_value( $post_id, 'newsvoice_article_dek' ) : ( $defaults['dek'] ?? '' );
	$hero_caption = $post_id ? newsvoice_article_builder_get_value( $post_id, 'newsvoice_hero_caption' ) : ( $defaults['hero_caption'] ?? '' );
	$sources      = $post_id ? newsvoice_article_builder_get_value( $post_id, 'newsvoice_sources' ) : ( $defaults['sources'] ?? '' );
	$support_image_url   = $post_id ? newsvoice_article_builder_get_value( $post_id, 'newsvoice_support_image_url' ) : ( $defaults['support_image_url'] ?? '' );
	$medialinq_image_url = $post_id ? newsvoice_article_builder_get_value( $post_id, 'newsvoice_medialinq_image_url' ) : ( $defaults['medialinq_image_url'] ?? '' );
	$banner_image_url    = $post_id ? newsvoice_article_builder_get_value( $post_id, 'newsvoice_banner_image_url' ) : ( $defaults['banner_image_url'] ?? '' );
	$support_url         = $post_id ? newsvoice_article_builder_get_value( $post_id, 'newsvoice_support_url' ) : ( $defaults['support_url'] ?? '' );
	$medialinq_url       = $post_id ? newsvoice_article_builder_get_value( $post_id, 'newsvoice_medialinq_url' ) : ( $defaults['medialinq_url'] ?? '' );
	$banner_url          = $post_id ? newsvoice_article_builder_get_value( $post_id, 'newsvoice_banner_url' ) : ( $defaults['banner_url'] ?? '' );
	?>
	<?php if ( 'all' === $section || 'header' === $section ) : ?>
	<div class="nv-article-builder-card">
		<h2><?php esc_html_e( 'Artikelhuvud', 'newsvoice-article-builder' ); ?></h2>
		<label for="nv-article-kicker"><?php esc_html_e( 'Etikett / kicker', 'newsvoice-article-builder' ); ?></label>
		<input id="nv-article-kicker" class="widefat" type="text" name="article_kicker" value="<?php echo esc_attr( $kicker ); ?>" placeholder="Analys" data-preview-field="kicker">

		<label for="nv-article-dek"><?php esc_html_e( 'Ingress under rubrik', 'newsvoice-article-builder' ); ?></label>
		<textarea id="nv-article-dek" class="widefat" rows="3" name="newsvoice_article_dek" data-preview-field="dek"><?php echo esc_textarea( $dek ); ?></textarea>

		<label for="nv-hero-caption"><?php esc_html_e( 'Bildtext till utvald bild', 'newsvoice-article-builder' ); ?></label>
		<textarea id="nv-hero-caption" class="widefat" rows="2" name="newsvoice_hero_caption" data-preview-field="hero_caption"><?php echo esc_textarea( $hero_caption ); ?></textarea>
	</div>
	<?php endif; ?>

	<?php if ( 'all' === $section || 'end' === $section ) : ?>
	<div class="nv-article-builder-card">
		<h2><?php esc_html_e( 'Källor och slutsektioner', 'newsvoice-article-builder' ); ?></h2>
		<label for="nv-sources"><?php esc_html_e( 'Källor', 'newsvoice-article-builder' ); ?></label>
		<textarea id="nv-sources" class="widefat" rows="5" name="newsvoice_sources" data-preview-field="sources" placeholder="En källa per rad. Exempel: https://newsvoice.se/ | NewsVoice | Samlad bevakning"><?php echo esc_textarea( $sources ); ?></textarea>

		<?php newsvoice_article_builder_image_control( $post_id, 'newsvoice_support_image_id', __( 'Stödannons', 'newsvoice-article-builder' ), $support_image_url, 'newsvoice_support_image_url' ); ?>
		<label for="nv-support-url"><?php esc_html_e( 'Länk för stödannons', 'newsvoice-article-builder' ); ?></label>
		<input id="nv-support-url" class="widefat" type="url" name="newsvoice_support_url" value="<?php echo esc_attr( $support_url ); ?>" placeholder="https://newsvoice.se/donera/">

		<?php newsvoice_article_builder_image_control( $post_id, 'newsvoice_medialinq_image_id', __( 'Medialinq-bild', 'newsvoice-article-builder' ), $medialinq_image_url, 'newsvoice_medialinq_image_url' ); ?>
		<label for="nv-medialinq-url"><?php esc_html_e( 'Länk för Medialinq', 'newsvoice-article-builder' ); ?></label>
		<input id="nv-medialinq-url" class="widefat" type="url" name="newsvoice_medialinq_url" value="<?php echo esc_attr( $medialinq_url ); ?>" placeholder="https://newsvoice.se/donera/">

		<?php newsvoice_article_builder_image_control( $post_id, 'newsvoice_banner_image_id', __( 'Banner längst ned', 'newsvoice-article-builder' ), $banner_image_url, 'newsvoice_banner_image_url' ); ?>
		<label for="nv-banner-url"><?php esc_html_e( 'Länk för banner', 'newsvoice-article-builder' ); ?></label>
		<input id="nv-banner-url" class="widefat" type="url" name="newsvoice_banner_url" value="<?php echo esc_attr( $banner_url ); ?>" placeholder="https://newsvoice.se/annonsera/">
	</div>
	<?php endif; ?>
	<?php
}

function newsvoice_article_builder_render_sources_preview( string $sources ): void {
	$lines = array_filter( array_map( 'trim', preg_split( '/\R/', $sources ) ?: array() ) );

	if ( ! $lines ) {
		return;
	}
	?>
	<h2 class="article-end-title"><?php esc_html_e( 'Källor', 'newsvoice-article-builder' ); ?></h2>
	<ul class="article-sources">
		<?php foreach ( $lines as $line ) : ?>
			<?php
			$parts = array_map( 'trim', explode( '|', $line ) );
			$url   = $parts[0] ?? '';
			$label = $parts[1] ?? $url;
			$note  = $parts[2] ?? '';
			?>
			<li>
				<?php if ( $url ) : ?>
					<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $label ); ?></a>
				<?php else : ?>
					<?php echo esc_html( $label ); ?>
				<?php endif; ?>
				<?php if ( $note ) : ?>
					<?php echo esc_html( ' - ' . $note ); ?>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php
}

function newsvoice_article_builder_render_preview( int $post_id, ?WP_Post $post, array $defaults = array() ): void {
	$kicker       = $post_id ? newsvoice_article_builder_get_value( $post_id, 'article_kicker' ) : ( $defaults['kicker'] ?? '' );
	$dek          = $post_id ? newsvoice_article_builder_get_value( $post_id, 'newsvoice_article_dek' ) : ( $defaults['dek'] ?? '' );
	$article_ingress = $post_id ? newsvoice_article_builder_get_value( $post_id, 'newsvoice_article_ingress' ) : ( $defaults['ingress'] ?? '' );
	$hero_caption = $post_id ? newsvoice_article_builder_get_value( $post_id, 'newsvoice_hero_caption' ) : ( $defaults['hero_caption'] ?? '' );
	$hero_image_url = $post_id ? newsvoice_article_builder_get_value( $post_id, 'newsvoice_hero_image_url' ) : ( $defaults['hero_image_url'] ?? '' );
	$sources      = $post_id ? newsvoice_article_builder_get_value( $post_id, 'newsvoice_sources' ) : ( $defaults['sources'] ?? '' );
	$support_image_url   = $post_id ? newsvoice_article_builder_get_value( $post_id, 'newsvoice_support_image_url' ) : ( $defaults['support_image_url'] ?? '' );
	$medialinq_image_url = $post_id ? newsvoice_article_builder_get_value( $post_id, 'newsvoice_medialinq_image_url' ) : ( $defaults['medialinq_image_url'] ?? '' );
	$banner_image_url    = $post_id ? newsvoice_article_builder_get_value( $post_id, 'newsvoice_banner_image_url' ) : ( $defaults['banner_image_url'] ?? '' );
	$category     = $post_id ? get_the_category( $post_id ) : array();
	$category     = $category ? $category[0]->name : ( $defaults['category'] ?? __( 'Kategori', 'newsvoice-article-builder' ) );
	$title        = $post ? $post->post_title : ( $defaults['title'] ?? __( 'Artikelrubrik', 'newsvoice-article-builder' ) );
	$content      = $post ? $post->post_content : ( $defaults['content'] ?? '<p>Artikeltexten visas här medan du skriver.</p>' );
	if ( ! $article_ingress ) {
		$split_content   = newsvoice_article_builder_split_ingress_from_content( $content );
		$article_ingress = $split_content['ingress'];
		$content         = $split_content['content'];
	}
	$author_name  = $post ? get_the_author_meta( 'display_name', (int) $post->post_author ) : __( 'Redaktionen', 'newsvoice-article-builder' );
	?>
	<div class="nv-article-builder__preview">
		<h2><?php esc_html_e( 'Live preview', 'newsvoice-article-builder' ); ?></h2>
		<div class="article-builder-preview">
			<div class="article-builder-preview__canvas">
				<article class="article-builder-preview__article">
					<nav class="breadcrumbs"><span>Hem</span><span class="sep">›</span><span data-preview-output="category"><?php echo esc_html( $category ); ?></span></nav>
					<div class="article-category" data-preview-output="category_badge"><?php echo esc_html( $category ); ?></div>
					<div class="kicker" data-preview-output="kicker"><?php echo esc_html( $kicker ? $kicker : __( 'Analys', 'newsvoice-article-builder' ) ); ?></div>
					<h1 class="article-title" data-preview-output="title"><?php echo esc_html( $title ); ?></h1>
					<p class="article-dek" data-preview-output="dek"><?php echo esc_html( $dek ? $dek : __( 'Ingressen visas här medan du skriver.', 'newsvoice-article-builder' ) ); ?></p>
					<div class="article-meta"><?php echo esc_html( $author_name ? $author_name : __( 'Redaktionen', 'newsvoice-article-builder' ) ); ?> • <?php esc_html_e( 'Publicerad', 'newsvoice-article-builder' ); ?> <?php echo esc_html( $post ? get_the_date( 'j F Y, H:i', $post ) : '8 mars 2026, 14:20' ); ?></div>
					<div class="article-share" aria-label="<?php esc_attr_e( 'Dela artikeln', 'newsvoice-article-builder' ); ?>"><span class="article-share-label">Dela</span><span class="share-btn share-facebook">f</span><span class="share-btn share-x">x</span><span class="share-btn share-linkedin">in</span><span class="share-btn share-wechat">wc</span><span class="share-btn share-weibo">wb</span><span class="share-btn share-douyin">dy</span><span class="share-btn share-toutiao">tt</span></div>
					<div class="article-hero"><div class="article-builder-preview__image"><?php if ( $hero_image_url ) : ?><img src="<?php echo esc_url( $hero_image_url ); ?>" alt=""><?php else : ?><?php esc_html_e( 'Utvald bild visas på artikelsidan', 'newsvoice-article-builder' ); ?><?php endif; ?></div></div>
					<p class="article-hero-caption" data-preview-output="hero_caption"><?php echo esc_html( $hero_caption ); ?></p>
					<div class="article-body">
						<p class="article-ingress" data-preview-output="article_ingress"><?php echo esc_html( $article_ingress ); ?></p>
						<div data-preview-output="body"><?php echo wp_kses_post( $content ); ?></div>
					</div>
					<div class="article-end">
						<section class="article-end-section article-builder-preview__sources" data-preview-output="sources"><?php newsvoice_article_builder_render_sources_preview( $sources ); ?></section>
						<section class="article-end-section"><a class="article-support-card" data-preview-output="support_image" href="#"><span><?php if ( $support_image_url ) : ?><img src="<?php echo esc_url( $support_image_url ); ?>" alt=""><?php endif; ?></span></a></section>
						<section class="article-end-section">
							<div class="article-author-card">
								<img class="article-author-photo" src="<?php echo esc_url( newsvoice_article_builder_default_asset_url( 'journalist.png' ) ); ?>" alt="">
								<div class="article-author-copy">
									<a class="article-author-name" href="#"><?php echo esc_html( $author_name ? $author_name : __( 'Redaktionen', 'newsvoice-article-builder' ) ); ?></a>
									<a class="article-author-email" href="mailto:redaktionen@newsvoice.se">redaktionen@newsvoice.se</a>
								</div>
							</div>
						</section>
						<section class="article-end-section">
							<p class="article-medialinq-note"><?php esc_html_e( 'Du kan stötta NewsVoice via Medialinq', 'newsvoice-article-builder' ); ?></p>
							<a class="article-medialinq" data-preview-output="medialinq_image" href="#"><span><?php if ( $medialinq_image_url ) : ?><img src="<?php echo esc_url( $medialinq_image_url ); ?>" alt=""><?php endif; ?></span></a>
						</section>
						<section class="article-end-section"><a class="article-banner-card" data-preview-output="banner_image" href="#"><span><?php if ( $banner_image_url ) : ?><img src="<?php echo esc_url( $banner_image_url ); ?>" alt=""><?php endif; ?></span></a></section>
					</div>
				</article>
			</div>
		</div>
	</div>
	<?php
}

function newsvoice_article_builder_handle_form_submit(): void {
	if ( ! current_user_can( 'edit_posts' ) ) {
		wp_die( esc_html__( 'Du har inte behörighet att spara artiklar.', 'newsvoice-article-builder' ) );
	}

	if ( ! isset( $_POST['newsvoice_article_builder_form_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['newsvoice_article_builder_form_nonce'] ) ), 'newsvoice_article_builder_form_save' ) ) {
		wp_die( esc_html__( 'Säkerhetskontrollen misslyckades.', 'newsvoice-article-builder' ) );
	}

	$post_id     = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;
	$post_status = isset( $_POST['post_status'] ) && 'publish' === $_POST['post_status'] ? 'publish' : 'draft';
	$post_content = isset( $_POST['post_content'] ) ? wp_kses_post( wp_unslash( $_POST['post_content'] ) ) : '';
	$split_content = newsvoice_article_builder_split_ingress_from_content( $post_content );
	if ( $split_content['ingress'] ) {
		$post_content = $split_content['content'];
		if ( empty( $_POST['newsvoice_article_ingress'] ) ) {
			$_POST['newsvoice_article_ingress'] = $split_content['ingress'];
		}
	}
	$post_data   = array(
		'post_type'    => 'post',
		'post_title'   => isset( $_POST['post_title'] ) ? sanitize_text_field( wp_unslash( $_POST['post_title'] ) ) : '',
		'post_content' => $post_content,
		'post_status'  => $post_status,
	);

	if ( $post_id ) {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			wp_die( esc_html__( 'Du har inte behörighet att uppdatera artikeln.', 'newsvoice-article-builder' ) );
		}
		$post_data['ID'] = $post_id;
		$result          = wp_update_post( $post_data, true );
	} else {
		$result = wp_insert_post( $post_data, true );
	}

	if ( is_wp_error( $result ) ) {
		wp_die( esc_html( $result->get_error_message() ) );
	}

	$post_id  = (int) $result;
	$category = isset( $_POST['newsvoice_article_category'] ) ? absint( $_POST['newsvoice_article_category'] ) : 0;
	if ( $category ) {
		wp_set_post_categories( $post_id, array( $category ) );
	}

	$thumbnail_id = isset( $_POST['_thumbnail_id'] ) ? absint( $_POST['_thumbnail_id'] ) : 0;
	if ( $thumbnail_id ) {
		set_post_thumbnail( $post_id, $thumbnail_id );
	} else {
		delete_post_thumbnail( $post_id );
	}

	update_post_meta( $post_id, '_wp_page_template', NEWSVOICE_ARTICLE_BUILDER_TEMPLATE );
	newsvoice_article_builder_save_meta_fields( $post_id );

	wp_safe_redirect(
		add_query_arg(
			array(
				'page'    => 'newsvoice-article-builder',
				'post_id' => $post_id,
				'saved'   => 1,
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_newsvoice_article_builder_save', 'newsvoice_article_builder_handle_form_submit' );

function newsvoice_article_builder_sanitize_sources( string $sources ): string {
	$lines = array_filter( array_map( 'trim', preg_split( '/\R/', $sources ) ?: array() ) );
	$lines = array_map( 'sanitize_text_field', $lines );

	return implode( "\n", $lines );
}

function newsvoice_article_builder_save_meta_fields( int $post_id ): void {
	foreach ( newsvoice_article_builder_meta_keys() as $key => $type ) {
		$value = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : '';

		if ( 'image' === $type ) {
			update_post_meta( $post_id, $key, absint( $value ) );
			continue;
		}

		if ( 'url' === $type ) {
			update_post_meta( $post_id, $key, esc_url_raw( $value ) );
			continue;
		}

		if ( 'textarea' === $type && 'newsvoice_sources' === $key ) {
			update_post_meta( $post_id, $key, newsvoice_article_builder_sanitize_sources( (string) $value ) );
			continue;
		}

		if ( 'textarea' === $type ) {
			update_post_meta( $post_id, $key, sanitize_textarea_field( $value ) );
			continue;
		}

		update_post_meta( $post_id, $key, sanitize_text_field( $value ) );
	}
}

function newsvoice_article_builder_save_post( int $post_id ): void {
	if ( ! isset( $_POST['newsvoice_article_builder_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['newsvoice_article_builder_nonce'] ) ), 'newsvoice_article_builder_save' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	newsvoice_article_builder_save_meta_fields( $post_id );
}
add_action( 'save_post', 'newsvoice_article_builder_save_post' );
