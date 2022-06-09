<?php
/**
 * Primary Menu Template
 *
 * @package Blakely
 */

?>
<div id="site-header-menu" class="site-header-menu">
	<div id="primary-menu-wrapper" class="menu-wrapper">
		<div class="menu-toggle-wrapper">
			<button id="menu-toggle"  class="menu-toggle" aria-controls="top-menu" aria-expanded="false"><?php echo blakely_get_svg( array( 'icon' => 'bars' ) ); echo blakely_get_svg( array( 'icon' => 'close' ) ); ?><span class="menu-label"><?php echo esc_html_e( 'Menu', 'blakely' ); ?></span></button>
		</div><!-- .menu-toggle-wrapper -->

		<?php
		if ( get_theme_mod( 'blakely_header_cart_enable', 0 ) && function_exists( 'blakely_cart_link' ) ) {
			blakely_cart_link();
		}
		?>


		<?php
		if ( get_theme_mod( 'blakely_header_cart_enable', 0 ) && function_exists( 'blakely_myaccount_icon_link' ) ) {
			blakely_myaccount_icon_link();
		}
		?>

		<div class="menu-inside-wrapper">
			<?php if ( has_nav_menu( 'primary-menu' ) ) : ?>
				<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'blakely' ); ?>">
					<?php
						wp_nav_menu( array(
								'container'      => '',
								'theme_location' => 'primary-menu',
								'menu_id'        => 'primary-menu',
								'menu_class'     => 'menu nav-menu',
							)
						);
					?>
				</nav><!-- .main-navigation -->
			<?php else : ?>
				<nav id="site-navigation" class="main-navigation default-page-menu" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'blakely' ); ?>">
					<?php wp_page_menu(
						array(
							'menu_class' => 'primary-menu-container',
							'before'     => '<ul id="menu-primary-items" class="menu nav-menu">',
							'after'      => '</ul>',
						)
					); ?>
				</nav><!-- .main-navigation -->
			<?php endif; ?>

			<div class="mobile-social-search">
				<?php if ( has_nav_menu( 'social-menu' ) ) : ?>
					 <nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Social Menu', 'blakely' ); ?>">
					 <?php
						 wp_nav_menu( array(
							 'theme_location'  => 'social-menu',
							 'menu_class'      => 'social-links-menu',
							 'container'       => 'div',
							 'container_class' => 'menu-social-container',
							 'depth'           => 1,
							 'link_before'     => '<span class="screen-reader-text">',
							 'link_after'      => '</span>' . blakely_get_svg( array( 'icon' => 'chain' ) ),
						 ) );
					 ?>
				<?php endif;

				if ( get_theme_mod( 'blakely_primary_search_enable', 1 ) ) : ?>
				<div class="search-container">
					<?php get_search_form(); ?>
				</div>
				<?php endif; ?>
			</div><!-- .mobile-social-search -->
		</div><!-- .menu-inside-wrapper -->
	</div><!-- #primary-menu-wrapper.menu-wrapper -->

	<?php get_template_part( 'template-parts/header/woo-elements' ); ?>

	<div id="primary-search-wrapper" class="menu-wrapper">
		<div class="menu-toggle-wrapper">
			<button id="social-search-toggle" class="menu-toggle search-toggle"><?php echo blakely_get_svg( array( 'icon' => 'search' ) ); echo blakely_get_svg( array( 'icon' => 'close' ) ); ?><span class="screen-reader-text"><?php esc_html_e( 'Search', 'blakely' ); ?></span></button>
		</div><!-- .menu-toggle-wrapper -->

		<div class="menu-inside-wrapper">
			<div class="search-container">
				<?php get_Search_form(); ?>
			</div>
		</div><!-- .menu-inside-wrapper -->
	</div><!-- #social-search-wrapper.menu-wrapper -->
</div><!-- .site-header-menu -->
