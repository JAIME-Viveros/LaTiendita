<?php
/**
 * The template for displaying portfolio items
 *
 * @package Blakely
 */

$enable = get_theme_mod( 'blakely_portfolio_option', 'disabled' );

if ( ! blakely_check_section( $enable ) || ( ! class_exists( 'Essential_Content_Jetpack_Portfolio' ) && ! class_exists( 'Essential_Content_Pro_Jetpack_Portfolio' ) ) ) {
	// Bail if portfolio section is disabled.
	return;
}

$blakely_title  = get_option( 'jetpack_portfolio_title' );
$sub_title 	    = get_option( 'jetpack_portfolio_content' );

$classes[] = 'section';
$classes[] = 'jetpack-portfolio';
$classes[] = 'layout-three';

if( ! $blakely_title && ! $sub_title ) {
	$classes[] = 'no-section-heading';
}
?>

<div id="portfolio-content-section" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="wrapper">
		<?php if ( $blakely_title || $sub_title ) : ?>
			<div class="section-heading-wrapper portfolio-section-headline">
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

			</div><!-- .section-heading-wrapper -->
		<?php endif; ?>

		<div class="section-content-wrapper portfolio-content-wrapper layout-three">
			<div class="grid">
				<?php get_template_part( 'template-parts/portfolio/post-types', 'portfolio' ); ?>
			</div>
		</div><!-- .section-content-wrap -->
	</div><!-- .wrapper -->
</div><!-- #portfolio-section -->
