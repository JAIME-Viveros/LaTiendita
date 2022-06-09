<?php
/**
 * The template for displaying featured content
 *
 * @package Blakely
 */

$enable_content = get_theme_mod( 'blakely_featured_content_option', 'disabled' );

if ( ! blakely_check_section( $enable_content ) || ( ! class_exists( 'Essential_Content_Featured_Content' ) && ! class_exists( 'Essential_Content_Pro_Featured_Content' ) ) ) {
	// Bail if featured content is disabled.
	return;
}

$blakely_title = get_option( 'featured_content_title' );
$sub_title     = get_option( 'featured_content_content' );

$classes[] = 'layout-three';
$classes[] = 'featured-content';
$classes[] = 'section';

if( ! $blakely_title && ! $sub_title ) {
	$classes[] = 'no-section-heading';
}
?>

<div id="featured-content-section" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="wrapper">
		<?php if ( $blakely_title || $sub_title ) : ?>
			<div class="section-heading-wrapper featured-section-headline">
				<?php if ( $blakely_title ) : ?>
					<div class="section-title-wrapper">
						<h2 class="section-title"><?php echo wp_kses_post( $blakely_title ); ?></h2>
					</div><!-- .section-title-wrapper -->
				<?php endif; ?>

				<?php if ( $sub_title ) : ?>
					<div class="section-description">
						<p><?php echo wp_kses_post( $sub_title ); ?></p>
					</div><!-- .section-description-wrapper -->
				<?php endif; ?>
			</div><!-- .section-heading-wrap -->
		<?php endif; ?>

		<div class="section-content-wrapper featured-content-wrapper layout-three">
			<?php get_template_part( 'template-parts/featured-content/post-types-featured' ); ?>
		</div><!-- .section-content-wrap -->
	</div><!-- .wrapper -->
</div><!-- #featured-content-section -->
