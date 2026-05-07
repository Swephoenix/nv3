<?php
/**
 * Front page template.
 *
 * @package NewsVoice
 */

get_header();
?>
<main class="container">
	<?php if ( function_exists( 'newsvoice_homepage_builder_render_front_page' ) && newsvoice_homepage_builder_render_front_page() ) : ?>
	</main>
	<?php get_footer(); ?>
	<?php return; ?>
	<?php endif; ?>
	<div class="top-split-layout">
		<div class="left-col">
			<div class="section-header section-header--top">
				<h2>Senaste</h2>
			</div>
			<div id="featured-article-container">
				<a href="<?php echo esc_url( home_url( '/sample-article/' ) ); ?>" class="article-link">
					<div class="featured-article">
						<div class="featured-img-container">
							<div class="featured-img-placeholder" style="width: 60%; background: #ddd;"></div>
							<div class="featured-img-placeholder" style="width: 40%; background: #eee;"></div>
						</div>
						<div class="featured-text">
							<div class="label-red">KATEGORI</div>
							<h1>Laddar artikel...</h1>
						</div>
					</div>
				</a>
			</div>

			<div id="news-grid-3-container" class="news-grid-3"></div>

			<?php
			$sections = array(
				'economy-business-grid' => 'Redaktionens utvalda',
				'sverige-grid'          => 'Sverige',
				'varlden-grid'          => 'Världen',
				'opinion-grid'          => 'Opinion',
				'ekonomi-grid'          => 'Ekonomi',
				'halsa-grid'            => 'Hälsa & Vård',
				'media-grid'            => 'Media',
				'kultur-grid'           => 'Kultur',
				'teknik-grid'           => 'Teknik',
				'vardagstips-grid'      => 'Vardagstips',
				'engelska-grid'         => 'Engelska',
			);
			foreach ( $sections as $id => $title ) :
				?>
				<div class="first-column-width">
					<div class="section-header">
						<h2><?php echo esc_html( $title ); ?></h2>
						<?php if ( 'vardagstips-grid' === $id ) : ?>
							<p class="section-subtitle">Prepping, DIY</p>
						<?php endif; ?>
					</div>
					<div id="<?php echo esc_attr( $id ); ?>" class="news-grid-4"></div>
				</div>
			<?php endforeach; ?>

			<div class="must-watch-section">
				<div class="must-watch-title">Video / NewsVoice TV</div>
				<div class="video-container">
					<div class="main-video-area">
						<div class="youtube-overlay-top">Vad jag åt och träningspass | Tillbaka på hälsospåret</div>
						<div class="play-button"></div>
					</div>
					<div class="playlist-sidebar">
						<div class="playlist-item active"><div style="font-size: 16px; width: 20px;">▶</div><div class="playlist-info"><b>Vad jag åt och träningspass | Tillbaka på hälsospåret</b><span>16:51</span></div></div>
						<div class="playlist-item"><div style="font-size: 16px; width: 20px;">▶</div><div class="playlist-info"><b>Italienska inomhusmästerskapen 2019 | Stavhopp damer | HD</b><span>10:20</span></div></div>
						<div class="playlist-item"><div style="font-size: 16px; width: 20px;">▶</div><div class="playlist-info"><b>Cyklar på de bästa vägarna i Storbritannien</b><span>10:08</span></div></div>
					</div>
				</div>
			</div>

			<div class="first-column-width">
				<div id="middle-ads-placeholder" class="ads-placeholder ads-placeholder--wide"></div>
			</div>
		</div>

		<aside class="sidebar sidebar-3col" id="right-sidebar">
			<div class="sidebar-col">
				<div class="sidebar-title" id="sidebar-newsletter-title">Få vårt nyhetsbrev</div>
				<div class="newsletter-box">
					<input id="newsletter-email-input" type="email" placeholder="Din e-postadress">
					<button id="newsletter-submit-btn">Skicka</button>
				</div>
				<div class="sidebar-media-card">
					<a href="https://buymeacoffee.com/newsvoice" target="_blank" rel="noopener noreferrer">
						<img src="<?php echo esc_url( newsvoice_asset_uri( 'media/NewsVoice - Public Service på riktigt_files/buymeacofee.jpg' ) ); ?>" alt="Buy me a coffee - Stöd NewsVoice">
					</a>
				</div>
				<div class="ad-rect">
					<a href="<?php echo esc_url( home_url( '/annonsera/' ) ); ?>" style="display:block; text-decoration:none; color:#111;">
						<div style="background:#fff; border:1px solid #ddd; padding:16px; min-height:160px; display:flex; align-items:center; justify-content:center; text-align:center; font-weight:700; line-height:1.35;">Nå tusentals - Annonsera i Newsvoice</div>
					</a>
				</div>
				<div class="sidebar-title">Annonsera i NewsVoice</div>
				<div class="sidebar-media-card">
					<img src="<?php echo esc_url( newsvoice_asset_uri( 'media/NewsVoice - Public Service på riktigt_files/annonsera-i-newsvoice.jpg' ) ); ?>" alt="Annonspaket i NewsVoice">
				</div>
			</div>
			<div class="sidebar-col">
				<div class="sidebar-title" id="sidebar-advertisers-title">Annonser</div>
				<div class="sidebar-media-card"><img src="<?php echo esc_url( newsvoice_asset_uri( 'media/NewsVoice - Public Service på riktigt_files/goplay.jpg' ) ); ?>" alt="Goplay"></div>
				<div class="sidebar-media-card"><img src="<?php echo esc_url( newsvoice_asset_uri( 'media/NewsVoice - Public Service på riktigt_files/kasnogringos.png' ) ); ?>" alt="Casino Gringos"></div>
				<div class="sidebar-media-card"><img src="<?php echo esc_url( newsvoice_asset_uri( 'media/NewsVoice - Public Service på riktigt_files/AmbitionSverige.jpg' ) ); ?>" alt="Ambition Sverige"></div>
				<div class="sidebar-media-card"><img src="<?php echo esc_url( newsvoice_asset_uri( 'media/NewsVoice - Public Service på riktigt_files/Depositphotos-Logo-300px.png' ) ); ?>" alt="Depositphotos"></div>
			</div>
		</aside>
	</div>
</main>
<?php
get_footer();
