<?php
/**
 * The template for displaying testimonial items
 *
 * @package Blakely
 */

$enable = get_theme_mod( 'blakely_testimonial_option', 'disabled' );

if ( ! blakely_check_section( $enable ) || ( ! class_exists( 'Essential_Content_Jetpack_testimonial' ) && ! class_exists( 'Essential_Content_Pro_Jetpack_testimonial' ) ) ) {
	// Bail if featured content is disabled
	return;
}

$headline    = get_option( 'jetpack_testimonial_title', esc_html__( 'Testimonials', 'blakely' ) );
$subheadline = get_option( 'jetpack_testimonial_content' );

$classes[] = 'section testimonial-content-section';

if ( ! $headline && ! $subheadline ) {
	$classes[] = 'no-section-heading';
}
?>

<div id="testimonial-content-section" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="wrapper">

		<?php if ( $headline || $subheadline ) : ?>
			<div class="section-heading-wrapper testimonial-content-section-headline">
			<?php if ( $headline ) : ?>
				<div class="section-title-wrapper">
					<h2 class="section-title"><?php echo wp_kses_post( $headline ); ?></h2>
				</div><!-- .section-title-wrapper -->
			<?php endif; ?>

			<?php if ( $subheadline ) : ?>
				<div class="section-description">
					<p><?php echo wp_kses_post( $subheadline ); ?></p>
				</div><!-- .section-description-wrapper -->
			<?php endif; ?>

			</div><!-- .section-heading-wrapper -->
		<?php endif; 

		$content_classes = 'section-content-wrapper testimonial-content-wrapper';
		$content_classes .= ' testimonial-slider owl-carousel';
		$content_classes .= ' owl-dots-enabled';
		?>

		<div class="<?php echo esc_attr( $content_classes ); ?>">
			<?php get_template_part( 'template-parts/testimonial/post-types', 'testimonial' ); ?>
		</div><!-- .section-content-wrapper -->
	</div><!-- .wrapper -->
</div><!-- .testimonial-content-section -->
