<?php
/**
 * Theme header.
 *
 * @package NewsVoice
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="container">
	<div id="site-top">
		<div class="sub-header">
			<?php if ( ! is_singular( 'post' ) ) : ?>
				<div id="current-date"><?php echo esc_html( wp_date( 'l, F j, Y' ) ); ?></div>
			<?php endif; ?>
			<div>
				<a href="<?php echo esc_url( home_url( '/annonsera/' ) ); ?>">Annonsera</a> |
				<a href="<?php echo esc_url( home_url( '/donera/' ) ); ?>">Donera</a> |
				<a href="<?php echo esc_url( home_url( '/kontakt/' ) ); ?>">Kontakt</a>
			</div>
		</div>

		<div class="logo-section">
			<div class="logo-cluster">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-box" aria-label="<?php bloginfo( 'name' ); ?>">
					<div class="logo-news">NEWS</div>
					<div class="logo-voice">VOICE</div>
				</a>
				<div class="social-box" aria-label="Sociala medier">
					<a class="social-link" href="https://www.facebook.com/profile.php?id=61587364922060" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M13.5 22v-8h2.7l.4-3h-3.1V9.1c0-.9.3-1.6 1.6-1.6H16.8V4.8c-.3 0-.9-.1-1.8-.1-3 0-4.9 1.8-4.9 5.1V11H7.2v3h2.9v8h3.4z"/></svg></a>
					<a class="social-link" href="https://www.youtube.com/@NewsVoiceTV" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M23 12.1s0-3.2-.4-4.7c-.2-.8-.8-1.5-1.6-1.7C19.5 5.3 12 5.3 12 5.3s-7.5 0-9 .4c-.8.2-1.4.9-1.6 1.7C1 8.9 1 12.1 1 12.1s0 3.2.4 4.7c.2.8.8 1.5 1.6 1.7 1.5.4 9 .4 9 .4s7.5 0 9-.4c.8-.2 1.4-.9 1.6-1.7.4-1.5.4-4.7.4-4.7zM9.6 15.8V8.4l6.2 3.7-6.2 3.7z"/></svg></a>
					<a class="social-link" href="https://x.com/newsvoicemag" target="_blank" rel="noopener noreferrer" aria-label="X"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18.9 2H22l-6.8 7.8L23.2 22H17l-4.9-6.4L6.5 22H3.4l7.3-8.4L1 2h6.4l4.4 5.8L18.9 2zm-1.1 18h1.7L6.5 3.9H4.7L17.8 20z"/></svg></a>
					<a class="social-link" href="https://t.me/newsvoicepublic" target="_blank" rel="noopener noreferrer" aria-label="Telegram"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21.5 4.6 18.3 19c-.2 1-.8 1.2-1.6.8l-4.5-3.3-2.2 2.1c-.2.2-.5.4-.9.4l.3-4.6 8.4-7.6c.4-.3-.1-.5-.5-.2L6.8 13.2l-4.4-1.4c-1-.3-1-.9.2-1.4L20 3.7c.8-.3 1.7.2 1.5.9z"/></svg></a>
				</div>
			</div>
			<div id="top-banner-slot" class="top-slot-placeholder">
				<?php if ( ! function_exists( 'newsvoice_homepage_builder_render_top_ad' ) || ! newsvoice_homepage_builder_render_top_ad() ) : ?>
					<div class="loading">Laddar annons...</div>
				<?php endif; ?>
			</div>
		</div>

		<nav class="main-nav" id="mainNav">
			<div class="mobile-menu-toggle" onclick="toggleMenu()">☰ MENY</div>
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'menu',
						'fallback_cb'    => 'newsvoice_fallback_menu',
					)
				);
			} else {
				newsvoice_fallback_menu();
			}
			?>
		</nav>
	</div>
</div>
