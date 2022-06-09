<?php
/**
 * The template used for displaying hero content
 *
 * @package Blakely
 */


$blakely_id = get_theme_mod( 'blakely_hero_content' );
$args['page_id'] = absint( $blakely_id );


// If $args is empty return false
if ( empty( $args ) ) {
	return;
}

// Create a new WP_Query using the argument previously created
$hero_query = new WP_Query( $args );
if ( $hero_query->have_posts() ) :
	while ( $hero_query->have_posts() ) :
		$hero_query->the_post();
		?>
		<div id="hero-section" class="hero-section section content-align-right text-align-left">
			<div class="wrapper">
				<div class="section-content-wrapper hero-content-wrapper">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="hentry-inner">
							<?php $post_thumbnail = blakely_post_thumbnail( 'full-image', 'html-with-bg', false ); // blakely_post_thumbnail( $image_size, $blakely_type = 'html', $echo = true, $no_thumb = false ).

						if ( $post_thumbnail ) :
							echo $post_thumbnail;
							?>
							<div class="entry-container">
						<?php else : ?>
							<div class="entry-container full-width">
						<?php endif; 
							$blakely_sub_title = get_theme_mod( 'blakely_hero_content_sub_title' ); ?>

							<div class="section-heading-wrapper">	
								<header class="entry-header">
									<?php the_title( '<h2 class="entry-title section-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h2>' ); ?>
								</header><!-- .entry-header -->

								<?php if ( $blakely_sub_title ) : ?>
									<div class="section-description">
										<p><?php echo wp_kses_post( $blakely_sub_title ); ?></p>
									</div><!-- .section-description-wrapper -->
								<?php endif; ?>
							</div>	


							<div class="entry-content">
								<?php									
									the_excerpt();

									wp_link_pages( array(
										'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'blakely' ) . '</span>',
										'after'       => '</div>',
										'link_before' => '<span class="page-number">',
										'link_after'  => '</span>',
										'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'blakely' ) . ' </span>%',
										'separator'   => '<span class="screen-reader-text">, </span>',
									) );
								?>
							</div><!-- .entry-content -->

							<?php if ( get_edit_post_link() ) : ?>
								<footer class="entry-footer">
									<div class="entry-meta">
										<?php
											edit_post_link(
												sprintf(
													/* translators: %s: Name of current post */
													esc_html__( 'Edit %s', 'blakely' ),
													the_title( '<span class="screen-reader-text">"', '"</span>', false )
												),
												'<span class="edit-link">',
												'</span>'
											);
										?>
									</div>	<!-- .entry-meta -->
								</footer><!-- .entry-footer -->
							<?php endif; ?>
						</div><!-- .hentry-inner -->
					</article>
				</div><!-- .section-content-wrapper -->
			</div><!-- .wrapper -->
		</div><!-- .section -->
	<?php
	endwhile;

	wp_reset_postdata();
endif;
