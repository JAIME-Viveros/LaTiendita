<?php
/**
 * Blakely Theme page
 *
 * @package Blakely
 */

function blakely_about_admin_style( $hook ) {
	if ( 'appearance_page_blakely-about' === $hook ) {
		wp_enqueue_style( 'blakely-about-admin', get_theme_file_uri( 'assets/css/about-admin.css' ), null, '1.0' );
	}
}
add_action( 'admin_enqueue_scripts', 'blakely_about_admin_style' );

/**
 * Add theme page
 */
function blakely_menu() {
	add_theme_page( esc_html__( 'About Theme', 'blakely' ), esc_html__( 'About Theme', 'blakely' ), 'edit_theme_options', 'blakely-about', 'blakely_about_display' );
}
add_action( 'admin_menu', 'blakely_menu' );

/**
 * Display About page
 */
function blakely_about_display() {
	$theme = wp_get_theme();
	?>
	<div class="wrap about-wrap full-width-layout">
		<h1><?php echo esc_html( $theme ); ?></h1>
		<div class="about-theme">
			<div class="theme-description">
				<p class="about-text">
					<?php
					// Remove last sentence of description.
					$description = explode( '. ', $theme->get( 'Description' ) );

					array_pop( $description );

					$description = implode( '. ', $description );

					echo esc_html( $description . '.' );
				?></p>
				<p class="actions">
					<a href="<?php echo esc_url( 'https://catchthemes.com/themes/blakely' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Theme Info', 'blakely' ); ?></a>

					<a href="<?php echo esc_url( 'https://catchthemes.com/demo/blakely' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'View Demo', 'blakely' ); ?></a>

					<a href="<?php echo esc_url( 'https://catchthemes.com/themes/blakely/#theme-instructions' ); ?>" class="button button-primary" target="_blank"><?php esc_html_e( 'Theme Instructions', 'blakely' ); ?></a>

					<a href="<?php echo esc_url( 'https://wordpress.org/support/theme/blakely/reviews/#new-post' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Rate this theme', 'blakely' ); ?></a>

					<a href="<?php echo esc_url( 'https://catchthemes.com/themes/blakely/#compare' ); ?>" class="button button-primary" target="_blank"><?php esc_html_e( 'Compare free Vs Pro',  'blakely' ); ?></a>

					<a href="<?php echo esc_url( 'https://catchthemes.com/themes/blakely-pro' ); ?>" class="green button button-secondary" target="_blank"><?php esc_html_e( 'Upgrade to pro', 'blakely' ); ?></a>
				</p>
			</div>

			<div class="theme-screenshot">
				<img src="<?php echo esc_url( $theme->get_screenshot() ); ?>" />
			</div>

		</div>

		<nav class="nav-tab-wrapper wp-clearfix" aria-label="<?php esc_attr_e( 'Secondary menu', 'blakely' ); ?>">
			<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'blakely-about' ), 'themes.php' ) ) ); ?>" class="nav-tab<?php echo ( isset( $_GET['page'] ) && 'blakely-about' === $_GET['page'] && ! isset( $_GET['tab'] ) ) ?' nav-tab-active' : ''; ?>"><?php esc_html_e( 'About', 'blakely' ); ?></a>

			<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'blakely-about', 'tab' => 'import_demo' ), 'themes.php' ) ) ); ?>" class="nav-tab<?php echo ( isset( $_GET['tab'] ) && 'import_demo' === $_GET['tab'] ) ?' nav-tab-active' : ''; ?>"><?php esc_html_e( 'Import Demo', 'blakely' ); ?></a>
		</nav>

		<?php
			blakely_main_screen();

			blakely_import_demo();
		?>

		<div class="return-to-dashboard">
			<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
				<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
					<?php is_multisite() ? esc_html_e( 'Return to Updates', 'blakely' ) : esc_html_e( 'Return to Dashboard &rarr; Updates', 'blakely' ); ?>
				</a> |
			<?php endif; ?>
			<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? esc_html_e( 'Go to Dashboard &rarr; Home', 'blakely' ) : esc_html_e( 'Go to Dashboard', 'blakely' ); ?></a>
		</div>
	</div>
	<?php
}

/**
 * Output the main about screen.
 */
function blakely_main_screen() {
	if ( isset( $_GET['page'] ) && 'blakely-about' === $_GET['page'] && ! isset( $_GET['tab'] ) ) {
	?>
		<div class="feature-section two-col">
			<div class="col card">
				<h2 class="title"><?php esc_html_e( 'Theme Customizer', 'blakely' ); ?></h2>
				<p><?php esc_html_e( 'All Theme Options are available via Customize screen.', 'blakely' ) ?></p>
				<p><a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Customize', 'blakely' ); ?></a></p>
			</div>

			<div class="col card">
				<h2 class="title"><?php esc_html_e( 'Got theme support question?', 'blakely' ); ?></h2>
				<p><?php esc_html_e( 'Get genuine support from genuine people. Whether it\'s customization or compatibility, our seasoned developers deliver tailored solutions to your queries.', 'blakely' ) ?></p>
				<p><a href="<?php echo esc_url( 'https://catchthemes.com/support-forum' ); ?>" class="button button-primary"><?php esc_html_e( 'Support Forum', 'blakely' ); ?></a></p>
			</div>
		</div>
	<?php
	}
}

/**
 * Import Demo data for theme using catch themes demo import plugin
 */
function blakely_import_demo() {
	if ( isset( $_GET['tab'] ) && 'import_demo' === $_GET['tab'] ) {
	?>
		<div class="wrap about-wrap demo-import-wrap">
			<div class="feature-section one-col">
			<?php if ( class_exists( 'CatchThemesDemoImportPlugin' ) ) { ?>
				<div class="col card">
					<h2 class="title"><?php esc_html_e( 'Import Demo', 'blakely' ); ?></h2>
					<p><?php esc_html_e( 'You can easily import the demo content using the Catch Themes Demo Import Plugin.', 'blakely' ) ?></p>
					<p><a href="<?php echo esc_url( admin_url( 'themes.php?page=catch-themes-demo-import' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Import Demo', 'blakely' ); ?></a></p>
				</div>
				<?php } 
				else {
					$action = 'install-plugin';
					$slug   = 'catch-themes-demo-import';
					$install_url = wp_nonce_url(
						    add_query_arg(
						        array(
						            'action' => $action,
						            'plugin' => $slug
						        ),
						        admin_url( 'update.php' )
						    ),
						    $action . '_' . $slug
						); ?>
					<div class="col card">
					<h2 class="title"><?php esc_html_e( 'Install Catch Themes Demo Import Plugin', 'blakely' ); ?></h2>
					<p><?php esc_html_e( 'You can easily import the demo content using the Catch Themes Demo Import Plugin.', 'blakely' ) ?></p>
					<p><a href="<?php echo esc_url( $install_url ); ?>" class="button button-primary"><?php esc_html_e( 'Install Plugin', 'blakely' ); ?></a></p>
				</div>
				<?php } ?>
			</div>
		</div>
	<?php
	}
}
