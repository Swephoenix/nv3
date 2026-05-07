<?php
/**
 * Main posts index.
 *
 * @package NewsVoice
 */

get_header();
?>
<main class="container">
	<div class="section-header section-header--top">
		<h2><?php single_post_title(); ?></h2>
	</div>
	<div class="news-grid-4">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : ?>
				<?php the_post(); ?>
				<?php newsvoice_post_card( get_post() ); ?>
			<?php endwhile; ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Inga artiklar hittades.', 'newsvoice' ); ?></p>
		<?php endif; ?>
	</div>
	<?php the_posts_pagination(); ?>
</main>
<?php
get_footer();

