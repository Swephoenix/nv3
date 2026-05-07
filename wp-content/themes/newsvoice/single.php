<?php
/**
 * Single post template.
 *
 * @package NewsVoice
 */

get_header();
?>
<main class="container">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<article <?php post_class( 'article' ); ?>>
				<?php $category = get_the_category(); ?>
				<?php if ( $category ) : ?>
					<div class="article-category"><?php echo esc_html( $category[0]->name ); ?></div>
				<?php endif; ?>
				<h1 class="article-title"><?php the_title(); ?></h1>
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
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="article-hero">
						<?php the_post_thumbnail( 'large' ); ?>
					</div>
				<?php endif; ?>
				<div class="article-body">
					<?php the_content(); ?>
				</div>
			</article>
		<?php endwhile; ?>
	<?php endif; ?>
</main>
<?php
get_footer();
