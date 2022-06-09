<?php
/**
 * The template used for displaying testimonial on front page
 *
 * @package Blakely
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="hentry-inner">

		<?php blakely_post_thumbnail( array(666, 666), 'html', true, false ); ?>
		
		<div class="entry-container">
			<div class="entry-content">
				<?php the_excerpt(); ?>
			</div>

			<?php $position = get_post_meta( get_the_id(), 'ect_testimonial_position', true ); ?>
				<header class="entry-header">
					<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
					
					<?php if ( $position ) : ?>
						<p class="entry-meta"><span class="position">
							<?php echo esc_html( $position ); ?></span>
						</p>
					<?php endif; ?>
				</header>			
		</div><!-- .entry-container -->	
	</div><!-- .hentry-inner -->
</article>
