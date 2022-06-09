<?php
/**
 * The template used for displaying playlist
 *
 * @package Blakely
 */

$blakely_id      = get_theme_mod( 'blakely_sticky_playlist' );
$args['page_id'] = absint( $blakely_id );


// If $args is empty return false
if ( empty( $args ) ) {
	return;
}

$class = '';
if( get_theme_mod( 'blakely_sticky_playlist_fluid_layout', 0 ) ) {
	$class = 'sticky-fluid';
}

// Create a new WP_Query using the argument previously created
$playlist_query = new WP_Query( $args );
if ( $playlist_query->have_posts() ) :
	while ( $playlist_query->have_posts() ) :
		$playlist_query->the_post();
		?>

		<div id="sticky-playlist-section" class="sticky-playlist-section <?php echo esc_attr( $class ); ?>">
			<div class="wrapper">
				<div class="section-content-wrapper playlist-wrapper">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="entry-container">
							<div class="entry-content">
								<?php the_content(); ?>
							</div><!-- .entry-content -->
						</div><!-- .entry-container -->
					</article><!-- #post-## -->
				</div><!-- .wrapper -->
			</div><!-- .section-content -->
		</div><!-- #playlist-section -->
	<?php
	endwhile;

	wp_reset_postdata();
endif;
