<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Blakely
 */

if( has_post_thumbnail() ) {
	$thumb = get_the_post_thumbnail_url( get_the_ID() );	
}
else {
	$thumb = trailingslashit( esc_url( get_template_directory_uri() ) ) . 'assets/images/no-thumb-960x640.jpg';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-wrapper hentry-inner">
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>" rel="bookmark">
				<?php the_post_thumbnail(); ?>
			</a>
		</div>

		<div class="entry-container">
			<div class="header">
				<header class="entry-header">
					<?php if ( is_sticky() ) { ?>
						<span class="sticky-post">
							<span><?php esc_html_e( 'Featured', 'blakely' ); ?></span>
						</span>
					<?php } ?>

					<?php
					if ( is_singular() ) :
						the_title( '<h1 class="entry-title">', '</h1>' );
					else :
						the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
					endif;?>

					<?php if ( 'post' === get_post_type() ) : ?>
					<div class="entry-meta">
						<?php blakely_posted_on(); ?>
						<span class="sep">|</span>
						<?php blakely_by_line(); ?>
					</div><!-- .entry-meta -->
					<?php
					endif; ?>
					
				</header><!-- .entry-header -->

				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div><!-- .entry-summary -->
			</div>

			<div class="footer-meta">
				<div class="entry-meta">
					<?php blakely_cat_list(); ?>
				</div>
			</div>
		</div><!-- .entry-container -->
	</div><!-- .hentry-inner -->
</article><!-- #post-<?php the_ID(); ?> -->
