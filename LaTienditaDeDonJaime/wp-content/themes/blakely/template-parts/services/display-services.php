<?php
/**
 * The template for displaying services content
 *
 * @package Blakely
 */

$enable_content = get_theme_mod( 'blakely_service_option', 'disabled' );

if ( ! blakely_check_section( $enable_content ) || ( ! class_exists( 'Essential_Content_Service' ) && ! class_exists( 'Essential_Content_Pro_Service' ) ) ) {
	// Bail if services content is disabled.
	return;
}

$blakely_title    = get_option( 'ect_service_title' );
$sub_title = get_option( 'ect_service_content' );

$classes[] = 'services-section';
$classes[] = 'section';

if ( ! $blakely_title && ! $sub_title ) {
	$classes[] = 'no-section-heading';
}
?>

<div id="services-section" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="wrapper">
		<?php if ( $blakely_title || $sub_title ) : ?>
			<div class="section-heading-wrapper">
				<?php if ( $blakely_title ) : ?>
					<div class="section-title-wrapper">
						<h2 class="section-title"><?php echo wp_kses_post( $blakely_title ); ?></h2>
					</div><!-- .page-title-wrapper -->
				<?php endif; ?>

				<?php if ( $sub_title ) : ?>
					<div class="section-description">
						<p><?php echo wp_kses_post( $sub_title ); ?></p>
					</div><!-- .section-description -->
				<?php endif; ?>

			</div><!-- .section-heading-wrapper -->
		<?php endif; ?>

		<div class="section-content-wrapper services-content-wrapper layout-three">
			<?php get_template_part( 'template-parts/services/post-types-services' ); ?>
		</div><!-- .services-wrapper -->
	</div><!-- .wrapper -->
</div><!-- #services-section -->
