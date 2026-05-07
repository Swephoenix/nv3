<?php
/**
 * Plugin Name: NewsVoice Popup Manager
 * Description: Controls the NewsVoice intro popup/splash content and lets editors disable it completely.
 * Version: 1.0.0
 * Author: NewsVoice
 * Text Domain: newsvoice-popup-manager
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const NEWSVOICE_POPUP_OPTION = 'newsvoice_popup_settings';

function newsvoice_popup_default_url( string $path ): string {
	if ( function_exists( 'newsvoice_asset_uri' ) ) {
		return newsvoice_asset_uri( $path );
	}

	return '';
}

function newsvoice_popup_default_settings(): array {
	return array(
		'enabled'      => 1,
		'active_mode'  => 'video',
		'show_switcher' => 1,
		'video_url'    => newsvoice_popup_default_url( 'demo/b_Animate_this_ad.mp4' ),
		'popup_url'    => newsvoice_popup_default_url( 'demo/popup.html' ),
		'event_url'    => newsvoice_popup_default_url( 'demo/popup-event.html' ),
		'custom_html'  => '<h1>Den som vill veta<br>läser NewsVoice.se</h1><p>Public Service på riktigt.</p>',
	);
}

function newsvoice_popup_get_settings(): array {
	$saved = get_option( NEWSVOICE_POPUP_OPTION, array() );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}

	return array_merge( newsvoice_popup_default_settings(), $saved );
}

function newsvoice_popup_sanitize_settings( array $input ): array {
	$allowed_modes = array( 'video', 'popup', 'event', 'custom' );
	$active_mode   = isset( $input['active_mode'] ) && in_array( $input['active_mode'], $allowed_modes, true ) ? $input['active_mode'] : 'video';

	return array(
		'enabled'       => empty( $input['enabled'] ) ? 0 : 1,
		'active_mode'   => $active_mode,
		'show_switcher' => empty( $input['show_switcher'] ) ? 0 : 1,
		'video_url'     => isset( $input['video_url'] ) ? esc_url_raw( $input['video_url'] ) : '',
		'popup_url'     => isset( $input['popup_url'] ) ? esc_url_raw( $input['popup_url'] ) : '',
		'event_url'     => isset( $input['event_url'] ) ? esc_url_raw( $input['event_url'] ) : '',
		'custom_html'   => isset( $input['custom_html'] ) ? wp_kses_post( $input['custom_html'] ) : '',
	);
}

function newsvoice_popup_activate(): void {
	if ( false === get_option( NEWSVOICE_POPUP_OPTION, false ) ) {
		add_option( NEWSVOICE_POPUP_OPTION, newsvoice_popup_default_settings() );
	}
}
register_activation_hook( __FILE__, 'newsvoice_popup_activate' );

function newsvoice_popup_enabled( bool $enabled = false ): bool {
	$settings = newsvoice_popup_get_settings();

	return $enabled || ( is_front_page() && ! empty( $settings['enabled'] ) );
}
add_filter( 'newsvoice_popup_enabled', 'newsvoice_popup_enabled' );

function newsvoice_popup_admin_menu(): void {
	add_menu_page(
		__( 'NewsVoice Popup', 'newsvoice-popup-manager' ),
		__( 'NewsVoice Popup', 'newsvoice-popup-manager' ),
		'manage_options',
		'newsvoice-popup-manager',
		'newsvoice_popup_settings_page',
		'dashicons-format-status',
		6
	);
}
add_action( 'admin_menu', 'newsvoice_popup_admin_menu' );

function newsvoice_popup_register_settings(): void {
	register_setting(
		'newsvoice_popup_settings',
		NEWSVOICE_POPUP_OPTION,
		array(
			'type'              => 'array',
			'sanitize_callback' => 'newsvoice_popup_sanitize_settings',
			'default'           => newsvoice_popup_default_settings(),
		)
	);
}
add_action( 'admin_init', 'newsvoice_popup_register_settings' );

function newsvoice_popup_admin_assets( string $hook_suffix ): void {
	if ( 'toplevel_page_newsvoice-popup-manager' !== $hook_suffix ) {
		return;
	}

	wp_enqueue_style(
		'newsvoice-popup-admin',
		plugins_url( 'assets/css/popup-admin.css', __FILE__ ),
		array(),
		'1.0.0'
	);
}
add_action( 'admin_enqueue_scripts', 'newsvoice_popup_admin_assets' );

function newsvoice_popup_settings_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$settings     = newsvoice_popup_get_settings();
	$status_label = ! empty( $settings['enabled'] ) ? __( 'Aktiv', 'newsvoice-popup-manager' ) : __( 'Avstängd', 'newsvoice-popup-manager' );
	$status_class = ! empty( $settings['enabled'] ) ? 'is-active' : 'is-inactive';
	?>
	<div class="wrap newsvoice-popup-admin">
		<div class="newsvoice-popup-admin__header">
			<div>
				<h1><?php esc_html_e( 'NewsVoice Popup', 'newsvoice-popup-manager' ); ?></h1>
				<p><?php esc_html_e( 'Hantera introduktionspopupen på startsidan.', 'newsvoice-popup-manager' ); ?></p>
			</div>
			<div class="newsvoice-popup-admin__status <?php echo esc_attr( $status_class ); ?>">
				<span><?php esc_html_e( 'Status', 'newsvoice-popup-manager' ); ?></span>
				<strong><?php echo esc_html( $status_label ); ?></strong>
			</div>
		</div>

		<form method="post" action="options.php">
			<?php settings_fields( 'newsvoice_popup_settings' ); ?>
			<div class="newsvoice-popup-admin__grid">
				<div class="newsvoice-popup-card">
					<h2><?php esc_html_e( 'Visning', 'newsvoice-popup-manager' ); ?></h2>
					<table class="form-table" role="presentation">
						<tr>
							<th scope="row"><?php esc_html_e( 'Aktiv', 'newsvoice-popup-manager' ); ?></th>
							<td>
								<label class="newsvoice-popup-toggle">
									<input type="checkbox" name="<?php echo esc_attr( NEWSVOICE_POPUP_OPTION ); ?>[enabled]" value="1" <?php checked( $settings['enabled'], 1 ); ?>>
									<span><?php esc_html_e( 'Visa popupen på startsidan', 'newsvoice-popup-manager' ); ?></span>
								</label>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="newsvoice-popup-active-mode"><?php esc_html_e( 'Standardvy', 'newsvoice-popup-manager' ); ?></label></th>
							<td>
								<select id="newsvoice-popup-active-mode" name="<?php echo esc_attr( NEWSVOICE_POPUP_OPTION ); ?>[active_mode]">
									<option value="video" <?php selected( $settings['active_mode'], 'video' ); ?>>Video</option>
									<option value="popup" <?php selected( $settings['active_mode'], 'popup' ); ?>>Popup / iframe</option>
									<option value="event" <?php selected( $settings['active_mode'], 'event' ); ?>>Event / iframe</option>
									<option value="custom" <?php selected( $settings['active_mode'], 'custom' ); ?>>Eget innehåll</option>
								</select>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Väljare', 'newsvoice-popup-manager' ); ?></th>
							<td>
								<label>
									<input type="checkbox" name="<?php echo esc_attr( NEWSVOICE_POPUP_OPTION ); ?>[show_switcher]" value="1" <?php checked( $settings['show_switcher'], 1 ); ?>>
									<?php esc_html_e( 'Visa knappar för att växla mellan innehållstyper', 'newsvoice-popup-manager' ); ?>
								</label>
							</td>
						</tr>
					</table>
				</div>

				<div class="newsvoice-popup-card">
					<h2><?php esc_html_e( 'Innehåll', 'newsvoice-popup-manager' ); ?></h2>
					<table class="form-table" role="presentation">
						<tr>
							<th scope="row"><label for="newsvoice-popup-video-url"><?php esc_html_e( 'Video-URL', 'newsvoice-popup-manager' ); ?></label></th>
							<td><input id="newsvoice-popup-video-url" class="regular-text" type="url" name="<?php echo esc_attr( NEWSVOICE_POPUP_OPTION ); ?>[video_url]" value="<?php echo esc_attr( $settings['video_url'] ); ?>"></td>
						</tr>
						<tr>
							<th scope="row"><label for="newsvoice-popup-popup-url"><?php esc_html_e( 'Popup iframe-URL', 'newsvoice-popup-manager' ); ?></label></th>
							<td><input id="newsvoice-popup-popup-url" class="regular-text" type="url" name="<?php echo esc_attr( NEWSVOICE_POPUP_OPTION ); ?>[popup_url]" value="<?php echo esc_attr( $settings['popup_url'] ); ?>"></td>
						</tr>
						<tr>
							<th scope="row"><label for="newsvoice-popup-event-url"><?php esc_html_e( 'Event iframe-URL', 'newsvoice-popup-manager' ); ?></label></th>
							<td><input id="newsvoice-popup-event-url" class="regular-text" type="url" name="<?php echo esc_attr( NEWSVOICE_POPUP_OPTION ); ?>[event_url]" value="<?php echo esc_attr( $settings['event_url'] ); ?>"></td>
						</tr>
						<tr>
							<th scope="row"><label for="newsvoice-popup-custom-html"><?php esc_html_e( 'Eget innehåll', 'newsvoice-popup-manager' ); ?></label></th>
							<td>
								<textarea id="newsvoice-popup-custom-html" class="large-text code" rows="8" name="<?php echo esc_attr( NEWSVOICE_POPUP_OPTION ); ?>[custom_html]"><?php echo esc_textarea( $settings['custom_html'] ); ?></textarea>
								<p class="description"><?php esc_html_e( 'HTML saneras med WordPress standardfilter.', 'newsvoice-popup-manager' ); ?></p>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

function newsvoice_popup_enqueue_assets(): void {
	if ( ! newsvoice_popup_enabled() ) {
		return;
	}

	wp_enqueue_style(
		'newsvoice-popup-manager',
		plugins_url( 'assets/css/popup-manager.css', __FILE__ ),
		array(),
		'1.0.0'
	);
}
add_action( 'wp_enqueue_scripts', 'newsvoice_popup_enqueue_assets' );

function newsvoice_popup_available_modes( array $settings ): array {
	$modes = array();

	if ( ! empty( $settings['video_url'] ) ) {
		$modes['video'] = __( 'Video', 'newsvoice-popup-manager' );
	}
	if ( ! empty( $settings['popup_url'] ) ) {
		$modes['popup'] = __( 'Popup', 'newsvoice-popup-manager' );
	}
	if ( ! empty( $settings['event_url'] ) ) {
		$modes['event'] = __( 'Event', 'newsvoice-popup-manager' );
	}
	if ( ! empty( $settings['custom_html'] ) ) {
		$modes['custom'] = __( 'Eget', 'newsvoice-popup-manager' );
	}

	return $modes;
}

function newsvoice_popup_render(): void {
	if ( ! newsvoice_popup_enabled() ) {
		return;
	}

	$settings    = newsvoice_popup_get_settings();
	$modes       = newsvoice_popup_available_modes( $settings );
	$active_mode = array_key_exists( $settings['active_mode'], $modes ) ? $settings['active_mode'] : array_key_first( $modes );

	if ( empty( $modes ) || ! $active_mode ) {
		return;
	}
	?>
	<div id="splash-screen" class="splash-screen" aria-label="Introduktionspopup" data-active-mode="<?php echo esc_attr( $active_mode ); ?>">
		<div class="splash-screen__panel">
			<?php if ( ! empty( $settings['show_switcher'] ) && count( $modes ) > 1 ) : ?>
				<div class="splash-screen__choicebar" aria-label="Välj popupinnehåll">
					<?php foreach ( $modes as $mode => $label ) : ?>
						<button id="<?php echo esc_attr( 'splash-choice-' . $mode ); ?>" class="splash-screen__choice<?php echo $active_mode === $mode ? ' is-active' : ''; ?>" type="button" data-splash-choice="<?php echo esc_attr( $mode ); ?>"><?php echo esc_html( $label ); ?></button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if ( isset( $modes['video'] ) ) : ?>
				<div id="splash-view-video" class="splash-screen__view" data-splash-mode="video"<?php echo 'video' !== $active_mode ? ' hidden' : ''; ?>>
					<video id="entry-splash-video" class="splash-screen__video" autoplay playsinline preload="auto">
						<source src="<?php echo esc_url( $settings['video_url'] ); ?>" type="video/mp4">
					</video>
				</div>
			<?php endif; ?>

			<?php if ( isset( $modes['popup'] ) ) : ?>
				<div id="splash-view-popup" class="splash-screen__view" data-splash-mode="popup"<?php echo 'popup' !== $active_mode ? ' hidden' : ''; ?>>
					<iframe id="entry-splash-popup" class="splash-screen__iframe" src="<?php echo esc_url( $settings['popup_url'] ); ?>" title="Popup splashscreen" loading="eager"></iframe>
				</div>
			<?php endif; ?>

			<?php if ( isset( $modes['event'] ) ) : ?>
				<div id="splash-view-event" class="splash-screen__view" data-splash-mode="event"<?php echo 'event' !== $active_mode ? ' hidden' : ''; ?>>
					<iframe id="entry-splash-event" class="splash-screen__iframe" src="<?php echo esc_url( $settings['event_url'] ); ?>" title="Event splashscreen" loading="eager"></iframe>
				</div>
			<?php endif; ?>

			<?php if ( isset( $modes['custom'] ) ) : ?>
				<div id="splash-view-custom" class="splash-screen__view" data-splash-mode="custom"<?php echo 'custom' !== $active_mode ? ' hidden' : ''; ?>>
					<div class="splash-screen__custom"><?php echo wp_kses_post( $settings['custom_html'] ); ?></div>
				</div>
			<?php endif; ?>

			<div class="splash-screen__meta">
				<div class="splash-screen__actions">
					<button id="splash-start-button" class="splash-screen__start" type="button">Starta med ljud</button>
				</div>
			</div>
		</div>
		<div class="splash-screen__footer">
			<button id="splash-skip-button" class="splash-screen__skip" type="button">Hoppa över</button>
		</div>
	</div>
	<?php
}
add_action( 'wp_body_open', 'newsvoice_popup_render', 20 );
