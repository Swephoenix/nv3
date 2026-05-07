<?php
/**
 * Template Name: standard_article
 * Template Post Type: post, page
 *
 * Standard article layout based on the static article.html reference.
 *
 * @package NewsVoice
 */

get_header();
?>
<main class="container">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<?php
			$categories        = get_the_category();
			$primary_category  = $categories ? $categories[0] : null;
			$kicker            = get_post_meta( get_the_ID(), 'article_kicker', true );
			$article_dek       = get_post_meta( get_the_ID(), 'newsvoice_article_dek', true );
			$article_ingress   = get_post_meta( get_the_ID(), 'newsvoice_article_ingress', true );
			$featured_image_id = get_post_thumbnail_id();
			$hero_image_url    = get_post_meta( get_the_ID(), 'newsvoice_hero_image_url', true );
			$image_caption     = get_post_meta( get_the_ID(), 'newsvoice_hero_caption', true );
			$image_caption     = $image_caption ? $image_caption : ( $featured_image_id ? wp_get_attachment_caption( $featured_image_id ) : '' );
			$sources_raw       = get_post_meta( get_the_ID(), 'newsvoice_sources', true );
			$sources           = array_filter( array_map( 'trim', preg_split( '/\R/', (string) $sources_raw ) ?: array() ) );
			$support_image_id  = absint( get_post_meta( get_the_ID(), 'newsvoice_support_image_id', true ) );
			$support_image_url = $support_image_id ? wp_get_attachment_image_url( $support_image_id, 'large' ) : get_post_meta( get_the_ID(), 'newsvoice_support_image_url', true );
			$support_image_url = $support_image_url ? $support_image_url : newsvoice_asset_uri( 'media/NVannons.png' );
			$support_url       = get_post_meta( get_the_ID(), 'newsvoice_support_url', true );
			$medialinq_image_id = absint( get_post_meta( get_the_ID(), 'newsvoice_medialinq_image_id', true ) );
			$medialinq_image_url = $medialinq_image_id ? wp_get_attachment_image_url( $medialinq_image_id, 'large' ) : get_post_meta( get_the_ID(), 'newsvoice_medialinq_image_url', true );
			$medialinq_url     = get_post_meta( get_the_ID(), 'newsvoice_medialinq_url', true );
			$banner_image_id   = absint( get_post_meta( get_the_ID(), 'newsvoice_banner_image_id', true ) );
			$banner_image_url  = $banner_image_id ? wp_get_attachment_image_url( $banner_image_id, 'large' ) : get_post_meta( get_the_ID(), 'newsvoice_banner_image_url', true );
			$banner_url        = get_post_meta( get_the_ID(), 'newsvoice_banner_url', true );
			?>
			<div class="top-split-layout">
				<div class="left-col">
					<article <?php post_class( 'article' ); ?>>
						<nav class="breadcrumbs" aria-label="<?php esc_attr_e( 'Brödsmulor', 'newsvoice' ); ?>">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Hem', 'newsvoice' ); ?></a>
							<?php if ( $primary_category ) : ?>
								<span class="sep">›</span>
								<a href="<?php echo esc_url( get_category_link( $primary_category ) ); ?>"><?php echo esc_html( $primary_category->name ); ?></a>
							<?php endif; ?>
						</nav>

						<?php if ( $primary_category ) : ?>
							<div class="article-category"><?php echo esc_html( $primary_category->name ); ?></div>
						<?php endif; ?>

						<?php if ( $kicker ) : ?>
							<div class="kicker"><?php echo esc_html( $kicker ); ?></div>
						<?php endif; ?>

						<h1 class="article-title"><?php the_title(); ?></h1>

						<?php if ( $article_dek || has_excerpt() ) : ?>
							<p class="article-dek"><?php echo esc_html( $article_dek ? $article_dek : get_the_excerpt() ); ?></p>
						<?php endif; ?>

						<div class="article-meta">
							<?php echo esc_html( get_the_author() ); ?> •
							<?php esc_html_e( 'Publicerad', 'newsvoice' ); ?>
							<?php echo esc_html( get_the_date( 'j F Y, H:i' ) ); ?>
						</div>

						<div class="article-share" aria-label="<?php esc_attr_e( 'Dela artikeln', 'newsvoice' ); ?>">
							<span class="article-share-label"><?php esc_html_e( 'Dela', 'newsvoice' ); ?></span>
							<a class="share-btn share-facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( get_permalink() ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Dela på Facebook', 'newsvoice' ); ?>">f</a>
							<a class="share-btn share-x" href="https://x.com/intent/tweet?url=<?php echo esc_url( get_permalink() ); ?>&amp;text=<?php echo esc_attr( rawurlencode( get_the_title() ) ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Dela på X', 'newsvoice' ); ?>">x</a>
							<a class="share-btn share-linkedin" href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo esc_url( get_permalink() ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Dela på LinkedIn', 'newsvoice' ); ?>">in</a>
							<a class="share-btn share-wechat" href="<?php echo esc_url( get_permalink() ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Dela via WeChat', 'newsvoice' ); ?>">wc</a>
							<a class="share-btn share-weibo" href="https://service.weibo.com/share/share.php?url=<?php echo esc_url( get_permalink() ); ?>&amp;title=<?php echo esc_attr( rawurlencode( get_the_title() ) ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Dela på Weibo', 'newsvoice' ); ?>">wb</a>
							<a class="share-btn share-douyin" href="https://www.douyin.com/" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Dela via Douyin', 'newsvoice' ); ?>">dy</a>
							<a class="share-btn share-toutiao" href="https://www.toutiao.com/" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Dela via Toutiao', 'newsvoice' ); ?>">tt</a>
						</div>

						<?php if ( has_post_thumbnail() || $hero_image_url ) : ?>
							<div class="article-hero">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php echo get_the_post_thumbnail( get_the_ID(), 'large' ); ?>
								<?php else : ?>
									<img src="<?php echo esc_url( $hero_image_url ); ?>" alt="">
								<?php endif; ?>
							</div>
							<?php if ( $image_caption ) : ?>
								<p class="article-hero-caption"><?php echo esc_html( $image_caption ); ?></p>
							<?php endif; ?>
						<?php endif; ?>

						<div class="article-body">
							<?php if ( $article_ingress ) : ?>
								<p class="article-ingress"><?php echo esc_html( $article_ingress ); ?></p>
							<?php endif; ?>
							<?php the_content(); ?>
						</div>

						<div class="article-end">
							<?php if ( $sources ) : ?>
								<section class="article-end-section">
									<h2 class="article-end-title"><?php esc_html_e( 'Källor', 'newsvoice' ); ?></h2>
									<ul class="article-sources">
										<?php foreach ( $sources as $source ) : ?>
											<?php
											$source_parts = array_map( 'trim', explode( '|', $source ) );
											$source_url   = $source_parts[0] ?? '';
											$source_label = $source_parts[1] ?? $source_url;
											$source_note  = $source_parts[2] ?? '';
											?>
											<li>
												<?php if ( $source_url ) : ?>
													<a href="<?php echo esc_url( $source_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $source_label ); ?></a>
												<?php else : ?>
													<?php echo esc_html( $source_label ); ?>
												<?php endif; ?>
												<?php if ( $source_note ) : ?>
													- <?php echo esc_html( $source_note ); ?>
												<?php endif; ?>
											</li>
										<?php endforeach; ?>
									</ul>
								</section>
							<?php endif; ?>

							<section class="article-end-section">
								<div class="article-author-card">
									<?php echo get_avatar( get_the_author_meta( 'ID' ), 96, '', get_the_author(), array( 'class' => 'article-author-photo' ) ); ?>
									<div class="article-author-copy">
										<a class="article-author-name" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a>
										<?php if ( get_the_author_meta( 'user_email' ) ) : ?>
											<a class="article-author-email" href="mailto:<?php echo esc_attr( get_the_author_meta( 'user_email' ) ); ?>"><?php echo esc_html( get_the_author_meta( 'user_email' ) ); ?></a>
										<?php endif; ?>
									</div>
								</div>
							</section>
							<?php if ( $support_image_url ) : ?>
								<section class="article-end-section">
									<a class="article-support-card" href="<?php echo esc_url( $support_url ? $support_url : home_url( '/donera/' ) ); ?>">
										<img src="<?php echo esc_url( $support_image_url ); ?>" alt="<?php esc_attr_e( 'Stöd NewsVoice', 'newsvoice' ); ?>">
									</a>
								</section>
							<?php endif; ?>
							<?php if ( $medialinq_image_id || $medialinq_image_url ) : ?>
								<section class="article-end-section">
									<p class="article-medialinq-note"><?php esc_html_e( 'Du kan stötta NewsVoice via Medialinq', 'newsvoice' ); ?></p>
									<a class="article-medialinq" href="<?php echo esc_url( $medialinq_url ? $medialinq_url : home_url( '/donera/' ) ); ?>">
										<?php if ( $medialinq_image_id ) : ?>
											<?php echo wp_get_attachment_image( $medialinq_image_id, 'large' ); ?>
										<?php else : ?>
											<img src="<?php echo esc_url( $medialinq_image_url ); ?>" alt="<?php esc_attr_e( 'Stöd NewsVoice via Medialinq', 'newsvoice' ); ?>">
										<?php endif; ?>
									</a>
								</section>
							<?php endif; ?>
							<?php if ( $banner_image_id || $banner_image_url ) : ?>
								<section class="article-end-section">
									<a class="article-banner-card" href="<?php echo esc_url( $banner_url ? $banner_url : home_url( '/annonsera/' ) ); ?>">
										<?php if ( $banner_image_id ) : ?>
											<?php echo wp_get_attachment_image( $banner_image_id, 'large' ); ?>
										<?php else : ?>
											<img src="<?php echo esc_url( $banner_image_url ); ?>" alt="<?php esc_attr_e( 'Annons i NewsVoice', 'newsvoice' ); ?>">
										<?php endif; ?>
									</a>
								</section>
							<?php endif; ?>
						</div>
					</article>
				</div>

				<aside class="sidebar" aria-label="<?php esc_attr_e( 'Sidokolumn', 'newsvoice' ); ?>">
					<div class="sidebar-title"><?php esc_html_e( 'Få vårt nyhetsbrev', 'newsvoice' ); ?></div>
					<div class="newsletter-box">
						<input type="email" placeholder="<?php esc_attr_e( 'Din e-postadress', 'newsvoice' ); ?>">
						<button type="button"><?php esc_html_e( 'Skicka', 'newsvoice' ); ?></button>
					</div>

					<div class="sidebar-title"><?php esc_html_e( 'Senaste nytt', 'newsvoice' ); ?></div>
					<ul class="news-timeline-list">
						<?php
						$latest_posts = get_posts(
							array(
								'numberposts'      => 6,
								'post_status'      => 'publish',
								'post__not_in'     => array( get_the_ID() ),
								'suppress_filters' => false,
							)
						);
						?>
						<?php foreach ( $latest_posts as $latest_post ) : ?>
							<li class="news-timeline-item">
								<span class="news-timeline-date"><?php echo esc_html( get_the_date( '', $latest_post ) ); ?></span>
								<a class="news-timeline-link" href="<?php echo esc_url( get_permalink( $latest_post ) ); ?>"><?php echo esc_html( get_the_title( $latest_post ) ); ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
				</aside>
			</div>
		<?php endwhile; ?>
	<?php endif; ?>
</main>
<?php
get_footer();
