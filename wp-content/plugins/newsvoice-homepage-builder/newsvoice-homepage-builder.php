<?php
/**
 * Plugin Name: NewsVoice Homepage Builder
 * Description: Controls selected front page articles and ad slots with an admin live preview.
 * Version: 1.0.0
 * Author: NewsVoice
 * Text Domain: newsvoice-homepage-builder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const NEWSVOICE_HOMEPAGE_BUILDER_OPTION  = 'newsvoice_homepage_builder_settings';
const NEWSVOICE_HOMEPAGE_BUILDER_VERSION = '1.0.0';

function newsvoice_homepage_builder_default_asset_url( string $path ): string {
	return get_template_directory_uri() . '/assets/media/' . ltrim( $path, '/' );
}

function newsvoice_homepage_builder_sections(): array {
	return array(
		'economy-business-grid' => __( 'Redaktionens utvalda', 'newsvoice-homepage-builder' ),
		'sverige-grid'          => __( 'Sverige', 'newsvoice-homepage-builder' ),
		'varlden-grid'          => __( 'Världen', 'newsvoice-homepage-builder' ),
		'opinion-grid'          => __( 'Opinion', 'newsvoice-homepage-builder' ),
		'ekonomi-grid'          => __( 'Ekonomi', 'newsvoice-homepage-builder' ),
		'halsa-grid'            => __( 'Hälsa & Vård', 'newsvoice-homepage-builder' ),
		'media-grid'            => __( 'Media', 'newsvoice-homepage-builder' ),
		'kultur-grid'           => __( 'Kultur', 'newsvoice-homepage-builder' ),
		'teknik-grid'           => __( 'Teknik', 'newsvoice-homepage-builder' ),
		'vardagstips-grid'      => __( 'Vardagstips', 'newsvoice-homepage-builder' ),
		'engelska-grid'         => __( 'Engelska', 'newsvoice-homepage-builder' ),
	);
}

function newsvoice_homepage_builder_default_sections(): array {
	return array(
		'economy-business-grid' => '115,116,117,118',
		'sverige-grid'          => '101,102,103,104',
		'varlden-grid'          => '105,107,108,109',
		'opinion-grid'          => '111,112,113,114',
		'ekonomi-grid'          => '115,116,117,118',
		'halsa-grid'            => '119,120,121,122',
		'media-grid'            => '123,124,125,126',
		'kultur-grid'           => '127,128,129,130',
		'teknik-grid'           => '131,132,133,134',
		'vardagstips-grid'      => '135,136,137,138',
		'engelska-grid'         => '139,140,141,142',
	);
}

function newsvoice_homepage_builder_default_settings(): array {
	return array(
		'enabled'           => 0,
		'featured_post_id'  => 1,
		'featured_image_url' => newsvoice_homepage_builder_default_asset_url( 'NewsVoice - Public Service på riktigt_files/Iran-armada-1170x600.jpg' ),
		'top_grid_post_ids' => '101,102,103',
		'sections'          => newsvoice_homepage_builder_default_sections(),
		'top_ad'            => array(
			'type'      => 'image',
			'image_id'  => 0,
			'image_url' => newsvoice_homepage_builder_default_asset_url( 'PremiumVpn.png' ),
			'url'       => '#',
			'iframe'    => '',
		),
		'middle_ad'         => array(
			'type'      => 'image',
			'image_id'  => 0,
			'image_url' => newsvoice_homepage_builder_default_asset_url( 'NVannons.png' ),
			'url'       => 'https://sasser.net/annonsformat/',
			'iframe'    => '',
		),
		'sidebar_ads'       => array(
			array(
				'type'      => 'image',
				'image_id'  => 0,
				'image_url' => newsvoice_homepage_builder_default_asset_url( 'newvoice-mullvad-vpn.png' ),
				'url'       => '#',
				'iframe'    => '',
			),
			array(
				'type'      => 'image',
				'image_id'  => 0,
				'image_url' => newsvoice_homepage_builder_default_asset_url( 'kaffeannons.png' ),
				'url'       => 'https://newsvoice.se/donera/',
				'iframe'    => '',
			),
			array(
				'type'      => 'image',
				'image_id'  => 0,
				'image_url' => newsvoice_homepage_builder_default_asset_url( 'NewsVoice - Public Service på riktigt_files/annonsera-i-newsvoice.jpg' ),
				'url'       => 'https://sasser.net/annonsformat/',
				'iframe'    => '',
			),
		),
	);
}

function newsvoice_homepage_builder_default_article_choices(): array {
	return array(
		array( 'id' => 1, 'title' => 'Israels och USA:s upptrappning mot Iran förändrar maktbalansen i Mellanöstern', 'category' => 'Krig & Fred', 'image' => newsvoice_homepage_builder_default_asset_url( 'NewsVoice - Public Service på riktigt_files/Iran-armada-1170x600.jpg' ) ),
		array( 'id' => 101, 'title' => 'Kommuner pressas av växande kostnader för äldreomsorg och skola', 'category' => 'Sverige', 'image' => newsvoice_homepage_builder_default_asset_url( 'NewsVoice - Public Service på riktigt_files/Carl-Bildt_Mark-Carney-900x491.jpg' ) ),
		array( 'id' => 102, 'title' => 'Ny svensk beredskapsplan ska stärka livsmedelsförsörjningen', 'category' => 'Sverige', 'image' => newsvoice_homepage_builder_default_asset_url( 'NewsVoice - Public Service på riktigt_files/Depositphotos_construction-worker-960x492.jpg' ) ),
		array( 'id' => 103, 'title' => 'Regioner varnar för längre vårdköer efter ny sparrunda', 'category' => 'Sverige', 'image' => newsvoice_homepage_builder_default_asset_url( 'NewsVoice - Public Service på riktigt_files/intravenost-e1769588724538-960x492.jpg' ) ),
		array( 'id' => 104, 'title' => 'Nordiskt säkerhetssamarbete fördjupas i Arktis', 'category' => 'Sverige', 'image' => newsvoice_homepage_builder_default_asset_url( 'NewsVoice - Public Service på riktigt_files/Military-Arctic-Foto-Arktisoutdoor.co_.uk_-900x506.jpg' ) ),
		array( 'id' => 105, 'title' => 'Biståndsmyndighet i USA pressas efter växande intern kritik', 'category' => 'USA', 'image' => newsvoice_homepage_builder_default_asset_url( 'NewsVoice - Public Service på riktigt_files/Maduro-Trump-960x492.jpg' ) ),
		array( 'id' => 107, 'title' => 'Ny kurs i Gaza sätter press på USA:s diplomati i regionen', 'category' => 'Mellanöstern', 'image' => newsvoice_homepage_builder_default_asset_url( 'NewsVoice - Public Service på riktigt_files/Jared-Kushner-New-Gaza-960x492.jpg' ) ),
		array( 'id' => 111, 'title' => 'Opinion: Europas ledare underskattar följderna av det nya säkerhetsläget', 'category' => 'Opinion', 'image' => newsvoice_homepage_builder_default_asset_url( 'NewsVoice - Public Service på riktigt_files/Caitlin-Johnstone-AI-edited-960x492.jpg' ) ),
		array( 'id' => 115, 'title' => 'Ny nordisk handelskorridor ska korta ledtider för mindre exportföretag', 'category' => 'Ekonomi', 'image' => newsvoice_homepage_builder_default_asset_url( 'NewsVoice - Public Service på riktigt_files/Canada-China-900x491.jpg' ) ),
		array( 'id' => 123, 'title' => 'Mediehus skär ned samtidigt som alternativa plattformar växer', 'category' => 'Media', 'image' => newsvoice_homepage_builder_default_asset_url( 'NewsVoice - Public Service på riktigt_files/internetfrihet-csno-960x492.jpg' ) ),
		array( 'id' => 131, 'title' => 'Kinesisk chiputvecklare visar upp genombrott inom kvantnära beräkningar', 'category' => 'Teknik', 'image' => newsvoice_homepage_builder_default_asset_url( 'NewsVoice - Public Service på riktigt_files/JUNI-cas.cn_-960x492.jpg' ) ),
	);
}

function newsvoice_homepage_builder_article_choices(): array {
	$posts = get_posts(
		array(
			'numberposts'      => 80,
			'post_status'      => array( 'publish', 'draft' ),
			'post_type'        => 'post',
			'suppress_filters' => false,
		)
	);

	if ( ! $posts ) {
		return newsvoice_homepage_builder_default_article_choices();
	}

	return array_map(
		static function ( WP_Post $post ): array {
			$category = get_the_category( $post->ID );

			return array(
				'id'       => (int) $post->ID,
				'title'    => get_the_title( $post ),
				'category' => $category ? $category[0]->name : __( 'Nyheter', 'newsvoice-homepage-builder' ),
				'image'    => get_the_post_thumbnail_url( $post->ID, 'medium_large' ) ?: '',
			);
		},
		$posts
	);
}

function newsvoice_homepage_builder_get_settings(): array {
	$saved = get_option( NEWSVOICE_HOMEPAGE_BUILDER_OPTION, array() );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}

	return array_replace_recursive( newsvoice_homepage_builder_default_settings(), $saved );
}

function newsvoice_homepage_builder_sanitize_id_list( string $value ): string {
	$ids = array_filter( array_map( 'absint', preg_split( '/[\s,]+/', $value ) ?: array() ) );

	return implode( ',', $ids );
}

function newsvoice_homepage_builder_sanitize_ad( array $ad ): array {
	return array(
		'type'      => isset( $ad['type'] ) && 'iframe' === $ad['type'] ? 'iframe' : 'image',
		'image_id'  => isset( $ad['image_id'] ) ? absint( $ad['image_id'] ) : 0,
		'image_url' => isset( $ad['image_url'] ) ? esc_url_raw( $ad['image_url'] ) : '',
		'url'       => isset( $ad['url'] ) ? esc_url_raw( $ad['url'] ) : '',
		'iframe'    => isset( $ad['iframe'] ) ? wp_kses( $ad['iframe'], array( 'iframe' => array( 'src' => true, 'width' => true, 'height' => true, 'loading' => true, 'style' => true, 'title' => true, 'allow' => true, 'allowfullscreen' => true ) ) ) : '',
	);
}

function newsvoice_homepage_builder_sanitize_settings( array $input ): array {
	$output = newsvoice_homepage_builder_default_settings();

	$output['enabled']           = empty( $input['enabled'] ) ? 0 : 1;
	$output['featured_post_id']  = isset( $input['featured_post_id'] ) ? absint( $input['featured_post_id'] ) : 0;
	$output['featured_image_url'] = isset( $input['featured_image_url'] ) ? esc_url_raw( $input['featured_image_url'] ) : '';
	$output['top_grid_post_ids'] = isset( $input['top_grid_post_ids'] ) ? newsvoice_homepage_builder_sanitize_id_list( (string) $input['top_grid_post_ids'] ) : '';

	foreach ( newsvoice_homepage_builder_sections() as $section_id => $label ) {
		$output['sections'][ $section_id ] = isset( $input['sections'][ $section_id ] ) ? newsvoice_homepage_builder_sanitize_id_list( (string) $input['sections'][ $section_id ] ) : '';
	}

	$output['top_ad']    = isset( $input['top_ad'] ) && is_array( $input['top_ad'] ) ? newsvoice_homepage_builder_sanitize_ad( $input['top_ad'] ) : $output['top_ad'];
	$output['middle_ad'] = isset( $input['middle_ad'] ) && is_array( $input['middle_ad'] ) ? newsvoice_homepage_builder_sanitize_ad( $input['middle_ad'] ) : $output['middle_ad'];

	$output['sidebar_ads'] = array();
	if ( isset( $input['sidebar_ads'] ) && is_array( $input['sidebar_ads'] ) ) {
		foreach ( array_slice( $input['sidebar_ads'], 0, 8 ) as $ad ) {
			if ( is_array( $ad ) ) {
				$output['sidebar_ads'][] = newsvoice_homepage_builder_sanitize_ad( $ad );
			}
		}
	}

	return $output;
}

function newsvoice_homepage_builder_admin_menu(): void {
	add_menu_page(
		__( 'NewsVoice Startsida', 'newsvoice-homepage-builder' ),
		__( 'NewsVoice Startsida', 'newsvoice-homepage-builder' ),
		'manage_options',
		'newsvoice-homepage-builder',
		'newsvoice_homepage_builder_settings_page',
		'dashicons-admin-home',
		4
	);
}
add_action( 'admin_menu', 'newsvoice_homepage_builder_admin_menu' );

function newsvoice_homepage_builder_register_settings(): void {
	register_setting(
		'newsvoice_homepage_builder_settings',
		NEWSVOICE_HOMEPAGE_BUILDER_OPTION,
		array(
			'type'              => 'array',
			'sanitize_callback' => 'newsvoice_homepage_builder_sanitize_settings',
			'default'           => newsvoice_homepage_builder_default_settings(),
		)
	);
}
add_action( 'admin_init', 'newsvoice_homepage_builder_register_settings' );

function newsvoice_homepage_builder_admin_assets( string $hook_suffix ): void {
	if ( 'toplevel_page_newsvoice-homepage-builder' !== $hook_suffix ) {
		return;
	}

	$css_path = plugin_dir_path( __FILE__ ) . 'assets/css/newsvoice-homepage-builder-admin.css';
	$js_path  = plugin_dir_path( __FILE__ ) . 'assets/js/newsvoice-homepage-builder-admin.js';

	wp_enqueue_media();
	wp_enqueue_style( 'newsvoice-homepage-builder-admin', plugins_url( 'assets/css/newsvoice-homepage-builder-admin.css', __FILE__ ), array(), newsvoice_homepage_builder_asset_version( $css_path ) );
	wp_enqueue_script( 'newsvoice-homepage-builder-admin', plugins_url( 'assets/js/newsvoice-homepage-builder-admin.js', __FILE__ ), array( 'jquery' ), newsvoice_homepage_builder_asset_version( $js_path ), true );
	wp_localize_script(
		'newsvoice-homepage-builder-admin',
		'newsvoiceHomepageBuilder',
		array(
			'articles' => newsvoice_homepage_builder_article_choices(),
		)
	);
}
add_action( 'admin_enqueue_scripts', 'newsvoice_homepage_builder_admin_assets' );

function newsvoice_homepage_builder_asset_version( string $path ): string {
	return file_exists( $path ) ? (string) filemtime( $path ) : NEWSVOICE_HOMEPAGE_BUILDER_VERSION;
}

function newsvoice_homepage_builder_image_field( string $name, array $ad ): void {
	$image_id  = absint( $ad['image_id'] ?? 0 );
	$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : ( $ad['image_url'] ?? '' );
	?>
	<input type="hidden" name="<?php echo esc_attr( NEWSVOICE_HOMEPAGE_BUILDER_OPTION . '[' . $name . '][image_id]' ); ?>" value="<?php echo esc_attr( $image_id ); ?>" data-homepage-image-id>
	<div class="nv-home-builder-image-preview" data-homepage-image-preview>
		<?php if ( $image_url ) : ?>
			<img src="<?php echo esc_url( $image_url ); ?>" alt="">
		<?php else : ?>
			<span><?php esc_html_e( 'Ingen bild vald', 'newsvoice-homepage-builder' ); ?></span>
		<?php endif; ?>
	</div>
	<button type="button" class="button nv-home-builder-select-image"><?php esc_html_e( 'Välj bild', 'newsvoice-homepage-builder' ); ?></button>
	<button type="button" class="button-link nv-home-builder-remove-image"><?php esc_html_e( 'Ta bort', 'newsvoice-homepage-builder' ); ?></button>
	<label><?php esc_html_e( 'Förifylld bild-URL', 'newsvoice-homepage-builder' ); ?></label>
	<input class="widefat" type="url" name="<?php echo esc_attr( NEWSVOICE_HOMEPAGE_BUILDER_OPTION . '[' . $name . '][image_url]' ); ?>" value="<?php echo esc_attr( $ad['image_url'] ?? '' ); ?>" data-homepage-image-url data-preview-field>
	<?php
}

function newsvoice_homepage_builder_ad_fields( string $name, string $label, array $ad ): void {
	?>
	<div class="nv-home-builder-ad" data-homepage-ad>
		<h3><?php echo esc_html( $label ); ?></h3>
		<label><?php esc_html_e( 'Typ', 'newsvoice-homepage-builder' ); ?></label>
		<select name="<?php echo esc_attr( NEWSVOICE_HOMEPAGE_BUILDER_OPTION . '[' . $name . '][type]' ); ?>" data-preview-field>
			<option value="image" <?php selected( $ad['type'] ?? 'image', 'image' ); ?>><?php esc_html_e( 'Bild', 'newsvoice-homepage-builder' ); ?></option>
			<option value="iframe" <?php selected( $ad['type'] ?? 'image', 'iframe' ); ?>><?php esc_html_e( 'Iframe', 'newsvoice-homepage-builder' ); ?></option>
		</select>
		<label><?php esc_html_e( 'Bild', 'newsvoice-homepage-builder' ); ?></label>
		<?php newsvoice_homepage_builder_image_field( $name, $ad ); ?>
		<label><?php esc_html_e( 'Länk för bildannons', 'newsvoice-homepage-builder' ); ?></label>
		<input class="widefat" type="url" name="<?php echo esc_attr( NEWSVOICE_HOMEPAGE_BUILDER_OPTION . '[' . $name . '][url]' ); ?>" value="<?php echo esc_attr( $ad['url'] ?? '' ); ?>" data-preview-field>
		<label><?php esc_html_e( 'Iframe-kod', 'newsvoice-homepage-builder' ); ?></label>
		<textarea class="widefat code" rows="3" name="<?php echo esc_attr( NEWSVOICE_HOMEPAGE_BUILDER_OPTION . '[' . $name . '][iframe]' ); ?>" data-preview-field><?php echo esc_textarea( $ad['iframe'] ?? '' ); ?></textarea>
	</div>
	<?php
}

function newsvoice_homepage_builder_article_choice_field( string $id, string $name, string $label, string $value, int $limit ): void {
	$ids         = newsvoice_homepage_builder_post_ids( $value );
	$status     = sprintf(
		/* translators: %d: selected article count */
		_n( 'Manuellt val: %d artikel vald', 'Manuellt val: %d artiklar valda', count( $ids ), 'newsvoice-homepage-builder' ),
		count( $ids )
	);
	?>
	<div class="nv-home-builder-choice" data-homepage-choice-field="<?php echo esc_attr( $id ); ?>" data-choice-limit="<?php echo esc_attr( $limit ); ?>">
		<input id="<?php echo esc_attr( $id ); ?>" type="hidden" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>" data-preview-field>
		<div class="nv-home-builder-choice__header">
			<div>
				<h3><?php echo esc_html( $label ); ?></h3>
				<p class="nv-home-builder-choice__status" data-choice-status><?php echo esc_html( $status ); ?></p>
			</div>
			<div class="nv-home-builder-choice__actions">
				<button type="button" class="button nv-home-builder-open-algo"><?php esc_html_e( 'Algoritm', 'newsvoice-homepage-builder' ); ?></button>
				<button type="button" class="button button-primary nv-home-builder-open-choice"><?php esc_html_e( 'Manuellt val', 'newsvoice-homepage-builder' ); ?></button>
			</div>
		</div>
		<div class="nv-home-builder-choice__preview" data-choice-preview></div>
	</div>
	<?php
}

function newsvoice_homepage_builder_settings_page(): void {
	$settings = newsvoice_homepage_builder_get_settings();
	?>
	<div class="wrap nv-home-builder">
		<h1><?php esc_html_e( 'NewsVoice Startsida', 'newsvoice-homepage-builder' ); ?></h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'newsvoice_homepage_builder_settings' ); ?>
			<div class="nv-home-builder-layout nv-home-builder-controls">
				<div class="nv-home-builder-panel">
					<h2><?php esc_html_e( 'Artiklar', 'newsvoice-homepage-builder' ); ?></h2>
					<label><input type="checkbox" name="<?php echo esc_attr( NEWSVOICE_HOMEPAGE_BUILDER_OPTION ); ?>[enabled]" value="1" <?php checked( $settings['enabled'], 1 ); ?>> <?php esc_html_e( 'Använd startsidesbyggaren', 'newsvoice-homepage-builder' ); ?></label>
					<?php newsvoice_homepage_builder_article_choice_field( 'nv-featured-post', NEWSVOICE_HOMEPAGE_BUILDER_OPTION . '[featured_post_id]', __( 'Huvudartikel', 'newsvoice-homepage-builder' ), (string) $settings['featured_post_id'], 1 ); ?>
					<label for="nv-featured-image-url"><?php esc_html_e( 'Förifylld huvudbild', 'newsvoice-homepage-builder' ); ?></label>
					<input id="nv-featured-image-url" class="widefat" type="url" name="<?php echo esc_attr( NEWSVOICE_HOMEPAGE_BUILDER_OPTION ); ?>[featured_image_url]" value="<?php echo esc_attr( $settings['featured_image_url'] ?? '' ); ?>" data-preview-field>
					<?php newsvoice_homepage_builder_article_choice_field( 'nv-top-grid-posts', NEWSVOICE_HOMEPAGE_BUILDER_OPTION . '[top_grid_post_ids]', __( 'Tre toppartiklar', 'newsvoice-homepage-builder' ), (string) $settings['top_grid_post_ids'], 3 ); ?>

					<h2><?php esc_html_e( 'Sektioner', 'newsvoice-homepage-builder' ); ?></h2>
					<?php foreach ( newsvoice_homepage_builder_sections() as $section_id => $label ) : ?>
						<?php newsvoice_homepage_builder_article_choice_field( 'nv-section-' . $section_id, NEWSVOICE_HOMEPAGE_BUILDER_OPTION . '[sections][' . $section_id . ']', $label, (string) ( $settings['sections'][ $section_id ] ?? '' ), 4 ); ?>
					<?php endforeach; ?>
				</div>

				<div class="nv-home-builder-panel">
					<h2><?php esc_html_e( 'Annonser', 'newsvoice-homepage-builder' ); ?></h2>
					<?php newsvoice_homepage_builder_ad_fields( 'top_ad', __( 'Uppe till höger', 'newsvoice-homepage-builder' ), $settings['top_ad'] ); ?>
					<?php newsvoice_homepage_builder_ad_fields( 'middle_ad', __( 'Bred annons i flödet', 'newsvoice-homepage-builder' ), $settings['middle_ad'] ); ?>
					<h3><?php esc_html_e( 'Högerpanel', 'newsvoice-homepage-builder' ); ?></h3>
					<?php for ( $i = 0; $i < 6; $i++ ) : ?>
						<?php newsvoice_homepage_builder_ad_fields( 'sidebar_ads][' . $i, sprintf( /* translators: %d: slot number */ __( 'Högerannons %d', 'newsvoice-homepage-builder' ), $i + 1 ), $settings['sidebar_ads'][ $i ] ?? array() ); ?>
					<?php endfor; ?>
				</div>

			</div>
			<div class="nv-home-builder-panel nv-home-builder-preview-panel">
				<h2><?php esc_html_e( 'Live preview', 'newsvoice-homepage-builder' ); ?></h2>
				<div class="homepage-builder-preview">
					<div class="homepage-builder-preview__canvas">
						<div class="homepage-builder-preview__masthead">
							<div class="homepage-builder-preview__logo">NEWS <span>VOICE</span></div>
							<div class="homepage-builder-preview__top-ad" data-homepage-preview-ad="top_ad"><?php esc_html_e( 'Annons uppe till höger', 'newsvoice-homepage-builder' ); ?></div>
						</div>
						<div class="homepage-builder-preview__nav"></div>
						<div class="homepage-builder-preview__layout">
							<div class="homepage-builder-preview__main">
								<div class="homepage-builder-preview__section-label"><?php esc_html_e( 'Senaste', 'newsvoice-homepage-builder' ); ?></div>
								<div class="homepage-builder-preview__hero" data-homepage-preview-output="featured">
									<?php esc_html_e( 'Huvudartikel', 'newsvoice-homepage-builder' ); ?>
								</div>
								<div class="homepage-builder-preview__cards" data-homepage-preview-output="top_grid"><span></span><span></span><span></span></div>
								<div class="homepage-builder-preview__section" data-homepage-preview-output="sections"><?php esc_html_e( 'Sektioner med valda artiklar', 'newsvoice-homepage-builder' ); ?></div>
								<div class="homepage-builder-preview__video">
									<div class="homepage-builder-preview__video-title"><?php esc_html_e( 'Video / NewsVoice TV', 'newsvoice-homepage-builder' ); ?></div>
									<div class="homepage-builder-preview__video-box">
										<div class="homepage-builder-preview__video-main">
											<div class="homepage-builder-preview__video-overlay"><?php esc_html_e( 'Vad jag åt och träningspass | Tillbaka på hälsospåret', 'newsvoice-homepage-builder' ); ?></div>
											<div class="homepage-builder-preview__play"></div>
										</div>
										<div class="homepage-builder-preview__playlist">
											<div class="homepage-builder-preview__playlist-item is-active"><b><?php esc_html_e( 'Vad jag åt och träningspass | Tillbaka på hälsospåret', 'newsvoice-homepage-builder' ); ?></b><span>16:51</span></div>
											<div class="homepage-builder-preview__playlist-item"><b><?php esc_html_e( 'Italienska inomhusmästerskapen 2019 | Stavhopp damer | HD', 'newsvoice-homepage-builder' ); ?></b><span>10:20</span></div>
											<div class="homepage-builder-preview__playlist-item"><b><?php esc_html_e( 'Cyklar på de bästa vägarna i Storbritannien', 'newsvoice-homepage-builder' ); ?></b><span>10:08</span></div>
										</div>
									</div>
								</div>
								<div class="homepage-builder-preview__english">
									<div class="homepage-builder-preview__section-label"><?php esc_html_e( 'Engelska', 'newsvoice-homepage-builder' ); ?></div>
									<div class="homepage-builder-preview__cards" data-homepage-preview-output="english_section"><span></span><span></span><span></span></div>
								</div>
								<div class="homepage-builder-preview__wide-ad" data-homepage-preview-ad="middle_ad"></div>
							</div>
							<div class="homepage-builder-preview__sidebar">
								<div class="homepage-builder-preview__newsletter"><?php esc_html_e( 'Få vårt nyhetsbrev', 'newsvoice-homepage-builder' ); ?></div>
								<div data-homepage-preview-output="sidebar_ads"><span></span><span></span><span></span></div>
								<div class="homepage-builder-preview__media-title"><?php esc_html_e( 'Mediapartners', 'newsvoice-homepage-builder' ); ?></div>
								<div class="homepage-builder-preview__media-logos"><span>Vaken.se</span><span>China Daily</span><span>TV BRICS</span></div>
							</div>
						</div>
						<div class="homepage-builder-preview__footer">
							<div><strong><?php esc_html_e( 'Public Service på riktigt', 'newsvoice-homepage-builder' ); ?></strong><span><?php esc_html_e( 'Stöd vårt dagliga arbete med en donation.', 'newsvoice-homepage-builder' ); ?></span></div>
							<div><strong><?php esc_html_e( 'Annonsera', 'newsvoice-homepage-builder' ); ?></strong><span>anna@sasser.net</span></div>
							<div><strong><?php esc_html_e( 'Kontakt', 'newsvoice-homepage-builder' ); ?></strong><span>redaktionen@newsvoice.se</span></div>
							<div><strong><?php esc_html_e( 'Utgivare', 'newsvoice-homepage-builder' ); ?></strong><span><?php esc_html_e( 'Torbjörn Sassersson', 'newsvoice-homepage-builder' ); ?></span></div>
						</div>
					</div>
				</div>
			</div>
			<div class="newsvoice-homepage-choice-modal" id="newsvoice-homepage-choice-modal" aria-hidden="true">
				<div class="newsvoice-homepage-choice-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="newsvoice-homepage-choice-title">
					<div class="newsvoice-homepage-choice-modal__header">
						<h2 id="newsvoice-homepage-choice-title"><?php esc_html_e( 'Välj artiklar manuellt', 'newsvoice-homepage-builder' ); ?></h2>
						<input type="search" class="regular-text" data-choice-search placeholder="<?php esc_attr_e( 'Sök artikel...', 'newsvoice-homepage-builder' ); ?>">
					</div>
					<div class="newsvoice-homepage-choice-modal__grid" data-choice-gallery></div>
					<div class="newsvoice-homepage-choice-modal__footer">
						<span><strong data-choice-count>0</strong> <?php esc_html_e( 'artiklar valda', 'newsvoice-homepage-builder' ); ?></span>
						<div>
							<button type="button" class="button nv-home-builder-close-choice"><?php esc_html_e( 'Avbryt', 'newsvoice-homepage-builder' ); ?></button>
							<button type="button" class="button button-primary nv-home-builder-save-choice"><?php esc_html_e( 'Spara urval', 'newsvoice-homepage-builder' ); ?></button>
						</div>
					</div>
				</div>
			</div>
			<div class="newsvoice-homepage-algo-modal" id="newsvoice-homepage-algo-modal" aria-hidden="true">
				<div class="newsvoice-homepage-choice-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="newsvoice-homepage-algo-title">
					<div class="newsvoice-homepage-choice-modal__header">
						<h2 id="newsvoice-homepage-algo-title"><?php esc_html_e( 'Välj algoritm', 'newsvoice-homepage-builder' ); ?></h2>
					</div>
					<div class="newsvoice-homepage-algo-modal__body">
						<label><input type="radio" name="newsvoice_homepage_algo_choice" value="latest" checked> <?php esc_html_e( 'Visa de senaste artiklarna', 'newsvoice-homepage-builder' ); ?></label>
						<label><input type="radio" name="newsvoice_homepage_algo_choice" value="category"> <?php esc_html_e( 'Visa artiklar från samma kategori', 'newsvoice-homepage-builder' ); ?></label>
						<label><input type="radio" name="newsvoice_homepage_algo_choice" value="random"> <?php esc_html_e( 'Visa slumpmässiga artiklar', 'newsvoice-homepage-builder' ); ?></label>
					</div>
					<div class="newsvoice-homepage-choice-modal__footer">
						<span><?php esc_html_e( 'Urvalet fylls direkt i sektionen.', 'newsvoice-homepage-builder' ); ?></span>
						<div>
							<button type="button" class="button nv-home-builder-close-algo"><?php esc_html_e( 'Avbryt', 'newsvoice-homepage-builder' ); ?></button>
							<button type="button" class="button button-primary nv-home-builder-save-algo"><?php esc_html_e( 'Verkställ', 'newsvoice-homepage-builder' ); ?></button>
						</div>
					</div>
				</div>
			</div>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

function newsvoice_homepage_builder_post_ids( string $ids ): array {
	return array_filter( array_map( 'absint', explode( ',', $ids ) ) );
}

function newsvoice_homepage_builder_posts( array $ids ): array {
	return $ids ? get_posts( array( 'post__in' => $ids, 'orderby' => 'post__in', 'post_status' => 'publish', 'numberposts' => count( $ids ) ) ) : array();
}

function newsvoice_homepage_builder_render_post_card( WP_Post $post, string $variant = 'grid' ): void {
	$category = get_the_category( $post->ID );
	$label    = $category ? $category[0]->name : __( 'Nyheter', 'newsvoice-homepage-builder' );
	$image    = get_the_post_thumbnail_url( $post->ID, 'medium_large' );
	?>
	<a href="<?php echo esc_url( get_permalink( $post ) ); ?>" class="article-link">
		<div class="<?php echo 'top' === $variant ? 'grid-item-3' : 'news-item-4'; ?>">
			<div class="<?php echo 'top' === $variant ? 'grid-item-3-thumb' : 'news-thumb'; ?>">
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

function newsvoice_homepage_builder_render_article_grid( string $class, array $posts, string $variant = 'grid' ): void {
	echo '<div class="' . esc_attr( $class ) . '">';
	foreach ( $posts as $post ) {
		newsvoice_homepage_builder_render_post_card( $post, $variant );
	}
	echo '</div>';
}

function newsvoice_homepage_builder_render_ad_slot( array $ad, string $class = 'sidebar-media-card' ): void {
	if ( 'iframe' === ( $ad['type'] ?? 'image' ) && ! empty( $ad['iframe'] ) ) {
		echo '<div class="' . esc_attr( $class ) . '">' . wp_kses( $ad['iframe'], array( 'iframe' => array( 'src' => true, 'width' => true, 'height' => true, 'loading' => true, 'style' => true, 'title' => true, 'allow' => true, 'allowfullscreen' => true ) ) ) . '</div>';
		return;
	}

	$image_id = absint( $ad['image_id'] ?? 0 );
	$image_url = $ad['image_url'] ?? '';
	if ( ! $image_id && ! $image_url ) {
		return;
	}

	$url = $ad['url'] ?? '';
	echo '<div class="' . esc_attr( $class ) . '">';
	if ( $url ) {
		echo '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer">';
	}
	if ( $image_id ) {
		echo wp_get_attachment_image( $image_id, 'large' );
	} else {
		echo '<img src="' . esc_url( $image_url ) . '" alt="">';
	}
	if ( $url ) {
		echo '</a>';
	}
	echo '</div>';
}

function newsvoice_homepage_builder_ad_slot_html( array $ad, string $class = 'sidebar-media-card' ): string {
	ob_start();
	newsvoice_homepage_builder_render_ad_slot( $ad, $class );

	return (string) ob_get_clean();
}

function newsvoice_homepage_builder_render_top_ad(): bool {
	$settings = newsvoice_homepage_builder_get_settings();
	if ( empty( $settings['enabled'] ) ) {
		return false;
	}

	$html = newsvoice_homepage_builder_ad_slot_html( $settings['top_ad'], 'newsvoice-homepage-top-ad' );
	if ( '' === trim( $html ) ) {
		return false;
	}

	echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	return true;
}

function newsvoice_homepage_builder_render_front_page(): bool {
	$settings = newsvoice_homepage_builder_get_settings();
	if ( empty( $settings['enabled'] ) ) {
		return false;
	}

	$featured = $settings['featured_post_id'] ? get_post( absint( $settings['featured_post_id'] ) ) : null;
	?>
	<div class="top-split-layout">
		<div class="left-col">
			<div class="section-header section-header--top"><h2><?php esc_html_e( 'Senaste', 'newsvoice-homepage-builder' ); ?></h2></div>
			<?php if ( $featured instanceof WP_Post ) : ?>
				<div id="featured-article-container">
					<a href="<?php echo esc_url( get_permalink( $featured ) ); ?>" class="article-link">
						<div class="featured-article">
							<div class="featured-img-container">
								<div class="featured-img-placeholder" style="width:100%;"><?php echo get_the_post_thumbnail( $featured, 'large' ); ?></div>
							</div>
							<div class="featured-text">
								<h1><?php echo esc_html( get_the_title( $featured ) ); ?></h1>
								<p><?php echo esc_html( get_the_excerpt( $featured ) ); ?></p>
							</div>
						</div>
					</a>
				</div>
			<?php endif; ?>
			<?php newsvoice_homepage_builder_render_article_grid( 'news-grid-3', newsvoice_homepage_builder_posts( newsvoice_homepage_builder_post_ids( $settings['top_grid_post_ids'] ) ), 'top' ); ?>
			<?php foreach ( newsvoice_homepage_builder_sections() as $section_id => $label ) : ?>
				<?php if ( 'engelska-grid' === $section_id ) : ?>
					<?php continue; ?>
				<?php endif; ?>
				<?php $posts = newsvoice_homepage_builder_posts( newsvoice_homepage_builder_post_ids( $settings['sections'][ $section_id ] ?? '' ) ); ?>
				<?php if ( $posts ) : ?>
					<div class="first-column-width">
						<div class="section-header"><h2><?php echo esc_html( $label ); ?></h2></div>
						<?php newsvoice_homepage_builder_render_article_grid( 'news-grid-4', $posts ); ?>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
			<div class="must-watch-section">
				<div class="must-watch-title"><?php esc_html_e( 'Video / NewsVoice TV', 'newsvoice-homepage-builder' ); ?></div>
				<div class="video-container">
					<div class="main-video-area">
						<div class="youtube-overlay-top"><?php esc_html_e( 'Vad jag åt och träningspass | Tillbaka på hälsospåret', 'newsvoice-homepage-builder' ); ?></div>
						<div class="play-button"></div>
					</div>
					<div class="playlist-sidebar">
						<div class="playlist-item active"><div style="font-size: 16px; width: 20px;">▶</div><div class="playlist-info"><b><?php esc_html_e( 'Vad jag åt och träningspass | Tillbaka på hälsospåret', 'newsvoice-homepage-builder' ); ?></b><span>16:51</span></div></div>
						<div class="playlist-item"><div style="font-size: 16px; width: 20px;">▶</div><div class="playlist-info"><b><?php esc_html_e( 'Italienska inomhusmästerskapen 2019 | Stavhopp damer | HD', 'newsvoice-homepage-builder' ); ?></b><span>10:20</span></div></div>
						<div class="playlist-item"><div style="font-size: 16px; width: 20px;">▶</div><div class="playlist-info"><b><?php esc_html_e( 'Cyklar på de bästa vägarna i Storbritannien', 'newsvoice-homepage-builder' ); ?></b><span>10:08</span></div></div>
					</div>
				</div>
			</div>
			<?php $english_posts = newsvoice_homepage_builder_posts( newsvoice_homepage_builder_post_ids( $settings['sections']['engelska-grid'] ?? '' ) ); ?>
			<?php if ( $english_posts ) : ?>
				<div class="first-column-width">
					<div class="section-header"><h2><?php esc_html_e( 'Engelska', 'newsvoice-homepage-builder' ); ?></h2></div>
					<?php newsvoice_homepage_builder_render_article_grid( 'news-grid-4', $english_posts ); ?>
				</div>
			<?php endif; ?>
			<div class="first-column-width">
				<?php newsvoice_homepage_builder_render_ad_slot( $settings['middle_ad'], 'ads-placeholder ads-placeholder--wide' ); ?>
			</div>
		</div>
		<aside class="sidebar sidebar-3col" id="right-sidebar">
			<div class="sidebar-col">
				<div class="sidebar-title"><?php esc_html_e( 'Annonser', 'newsvoice-homepage-builder' ); ?></div>
				<?php foreach ( array_slice( $settings['sidebar_ads'], 0, 3 ) as $ad ) : ?>
					<?php newsvoice_homepage_builder_render_ad_slot( $ad ); ?>
				<?php endforeach; ?>
				<div class="sidebar-title"><?php esc_html_e( 'Mediapartners', 'newsvoice-homepage-builder' ); ?></div>
				<div class="sidebar-logo-stack">
					<img src="<?php echo esc_url( newsvoice_homepage_builder_default_asset_url( 'NewsVoice - Public Service på riktigt_files/vaken-logo.jpg' ) ); ?>" alt="Vaken.se">
					<hr>
					<img src="<?php echo esc_url( newsvoice_homepage_builder_default_asset_url( 'NewsVoice - Public Service på riktigt_files/logo-ChinaDaily.com_.cn_.jpg' ) ); ?>" alt="China Daily">
					<hr>
					<img src="<?php echo esc_url( newsvoice_homepage_builder_default_asset_url( 'NewsVoice - Public Service på riktigt_files/logo-TV-BRICS.png' ) ); ?>" alt="TV BRICS">
				</div>
			</div>
			<div class="sidebar-col">
				<div class="sidebar-title"><?php esc_html_e( 'Annonser', 'newsvoice-homepage-builder' ); ?></div>
				<?php foreach ( array_slice( $settings['sidebar_ads'], 3, 3 ) as $ad ) : ?>
					<?php newsvoice_homepage_builder_render_ad_slot( $ad ); ?>
				<?php endforeach; ?>
			</div>
		</aside>
	</div>
	<?php
	return true;
}
