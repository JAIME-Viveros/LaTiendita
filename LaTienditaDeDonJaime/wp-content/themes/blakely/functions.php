<?php

/**
 * Blakely functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Blakely
 */

 /**
 * Add an HTML class to MediaElement.js container elements to aid styling.
 *
 * Extends the core _wpmejsSettings object to add a new feature via the
 * MediaElement.js plugin API.
 */
function blakely_mejs_add_container_class() {
	if ( ! wp_script_is( 'mediaelement', 'done' ) ) {
		return;
	}

	$next_track_text   = esc_attr__( 'Next Track', 'blakely' );
	$prev_track_text   = esc_attr__( 'Previous Track', 'blakely' );
	$toggle_text       = esc_attr__( 'Toggle Playlist', 'blakely' );

	$next_track_icon = blakely_get_svg( array(
		'icon'     => 'next',
		'fallback' => true,
	) );

	$prev_track_icon = blakely_get_svg( array(
		'icon'     => 'prev',
		'fallback' => true,
	) );

	$toggle_icon = blakely_get_svg( array(
		'icon'     => 'playlist',
		'fallback' => true,
	) );

	$toggle_close = blakely_get_svg( array(
		'icon'     => 'close',
		'fallback' => true,
	) );

 	?>
	<script>
	(function() {
		var settings = window._wpmejsSettings || {};

		settings.features = settings.features || mejs.MepDefaults.features;

		settings.features.push( 'blakely_class' );

		MediaElementPlayer.prototype.buildblakely_class = function(player, controls, layers, media) {
			if ( ! player.isVideo ) {
				var container = player.container[0] || player.container;

				container.style.height = '';
				container.style.width = '';
				player.options.setDimensions = false;
			}

			if ( jQuery( '#' + player.id ).parents('#sticky-playlist-section').length ) {
				player.container.addClass( 'mejs-container mejs-sticky-playlist-container' );

				jQuery( '#' + player.id ).parent().children('.wp-playlist-tracks').addClass('displaynone');

				var volume_slider = controls[0].children[5];

				if ( jQuery( '#' + player.id ).parent().children('.wp-playlist-tracks').length > 0) {
					var playlist_button =
					jQuery('<div class="mejs-playlist-button mejs-toggle-playlist ">' +
						'<button type="button" aria-controls="mep_0" title="<?php echo esc_attr( $toggle_text ); ?>"><?php echo $toggle_icon; ?><?php echo $toggle_close; ?>
						</button>' +
					'</div>')

					// append it to the toolbar
					.appendTo( jQuery( '#' + player.id ) )

					// add a click toggle event
					.on( 'click',function() {
						jQuery( '#' + player.id ).parent().children('.wp-playlist-tracks').slideToggle();
						jQuery( this ).toggleClass('is-open')
					});

					var play_button = controls[0].children[0];

					// Add next button after volume slider
					var next_button =
					jQuery('<div class="mejs-next-button mejs-next">' +
						'<button type="button" aria-controls="' + player.id
						+ '" title="<?php echo esc_attr( $next_track_text ); ?>"><?php echo $next_track_icon; ?></button>' +
					'</div>')

					// insert after volume slider
					.insertAfter(play_button)

					// add a click toggle event
					.on( 'click',function() {
						jQuery( '#' + player.id ).parent().find( '.wp-playlist-next').trigger('click');
					});

					// Add prev button after volume slider
					var previous_button =
					jQuery('<div class="mejs-previous-button mejs-previous">' +
						'<button type="button" aria-controls="' + player.id
						+ '" title="<?php echo esc_attr( $prev_track_text ); ?>"><?php echo $prev_track_icon; ?></button>' +
					'</div>')

					// insert after volume slider
					.insertBefore( play_button )

					// add a click toggle event
					.on( 'click',function() {
						jQuery( '#' + player.id ).parent().find( '.wp-playlist-prev').trigger('click');
					});
				}
			} else {
				player.container.addClass( 'mejs-container' );

				if ( jQuery( '#' + player.id ).parent().children('.wp-playlist-tracks').length > 0) {
					var play_button = controls[0].children[0];

					// Add next button after volume slider
					var next_button =
					jQuery('<div class="mejs-next-button mejs-next">' +
						'<button type="button" aria-controls="' + player.id
						+ '" title="<?php echo esc_attr( $next_track_text ); ?>"><?php echo $next_track_icon; ?></button>' +
					'</div>')

					// insert after volume slider
					.insertAfter(play_button)

					// add a click toggle event
					.on( 'click',function() {
						jQuery( '#' + player.id ).parent().find( '.wp-playlist-next').trigger('click');
					});

					// Add prev button after volume slider
					var previous_button =
					jQuery('<div class="mejs-previous-button mejs-previous">' +
						'<button type="button" aria-controls="' + player.id
						+ '" title="<?php echo esc_attr( $prev_track_text ); ?>"><?php echo $prev_track_icon; ?></button>' +
					'</div>')

					// insert after volume slider
					.insertBefore( play_button )

					// add a click toggle event
					.on( 'click',function() {
						jQuery( '#' + player.id ).parent().find( '.wp-playlist-prev').trigger('click');
					});
				}
			}
		}
	})();
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'blakely_mejs_add_container_class' );

if ( ! function_exists( 'blakely_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function blakely_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Blakely, use a find and replace
		 * to change 'blakely' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'blakely', get_parent_theme_file_path( '/languages' ) );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, and column width.
		 *
		 * Google fonts url addition
		 *
		 * Font Awesome addition
		 */
		$editor_style_url = 'assets/css/editor-style.css';

		if ( 'light' === get_theme_mod( 'editor_color_scheme', 'dark' ) ) {
			$editor_style_url = 'assets/css/editor-style-light.css';
		}

		add_editor_style( array(
				$editor_style_url,
				blakely_fonts_url(),
			)
		);

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		
		set_post_thumbnail_size( 960, 960, true ); // Ratio 1:1

		// Used in single post page
		add_image_size( 'blakely-single-post-page', 1920, 440, true ); 
		
		// Used in featured slider
		add_image_size( 'blakely-slider', 1920, 1080, true );
		
		// Used in logo slider
		add_image_size( 'blakely-logo-slider', 124, 93, true ); // Ratio 4:3
		
		// Used in Portfolio
		add_image_size( 'blakely-portfolio', 1920, 9999, true ); // Flexible Height

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary-menu'    => esc_html__( 'Primary', 'blakely' ),
			'social-menu'     => esc_html__( 'Floating Social Menu', 'blakely' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		/**
		 * Add support for essential widget image.
		 *
		 */
		add_theme_support( 'ew-newsletter-image' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );

		// Add custom editor font sizes.
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => esc_html__( 'Small', 'blakely' ),
					'shortName' => esc_html__( 'S', 'blakely' ),
					'size'      => 13,
					'slug'      => 'small',
				),
				array(
					'name'      => esc_html__( 'Normal', 'blakely' ),
					'shortName' => esc_html__( 'M', 'blakely' ),
					'size'      => 18,
					'slug'      => 'normal',
				),
				array(
					'name'      => esc_html__( 'Large', 'blakely' ),
					'shortName' => esc_html__( 'L', 'blakely' ),
					'size'      => 42,
					'slug'      => 'large',
				),
				array(
					'name'      => esc_html__( 'Huge', 'blakely' ),
					'shortName' => esc_html__( 'XL', 'blakely' ),
					'size'      => 56,
					'slug'      => 'huge',
				),
			)
		);

		// Add support for custom color scheme.
		add_theme_support( 'editor-color-palette', array(
			array(
				'name'  => esc_html__( 'White', 'blakely' ),
				'slug'  => 'white',
				'color' => '#ffffff',
			),
			array(
				'name'  => esc_html__( 'Black', 'blakely' ),
				'slug'  => 'black',
				'color' => '#000000',
			),
			array(
				'name'  => esc_html__( 'Eighty Black', 'blakely' ),
				'slug'  => 'eighty-black',
				'color' => '#151515',
			),
			array(
				'name'  => esc_html__( 'Sixty Five Black', 'blakely' ),
				'slug'  => 'sixty-five-black',
				'color' => '#151515',
			),
			array(
				'name'  => esc_html__( 'Gray', 'blakely' ),
				'slug'  => 'gray',
				'color' => '#444444',
			),
			array(
				'name'  => esc_html__( 'Medium Gray', 'blakely' ),
				'slug'  => 'medium-gray',
				'color' => '#7b7b7b',
			),
			array(
				'name'  => esc_html__( 'Light Gray', 'blakely' ),
				'slug'  => 'light-gray',
				'color' => '#f8f8f8',
			),
			array(
				'name'  => esc_html__( 'Dark Yellow', 'blakely' ),
				'slug'  => 'dark-yellow',
				'color' => '#ffa751',
			),
			array(
				'name'  => esc_html__( 'Yellow', 'blakely' ),
				'slug'  => 'yellow',
				'color' => '#f9a926',
			),
		) );
	}
endif;
add_action( 'after_setup_theme', 'blakely_setup' );

/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 *
 */
function blakely_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-2' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'sidebar-4' ) ) {
		$count++;
	}

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;

	}

	if ( $class ) {
		echo 'class="widget-area footer-widget-area ' . esc_attr( $class ) . '"';
	}
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function blakely_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'blakely_content_width', 920 );
}
add_action( 'after_setup_theme', 'blakely_content_width', 0 );

if ( ! function_exists( 'blakely_template_redirect' ) ) :
	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet for different value other than the default one
	 *
	 * @global int $content_width
	 */
	function blakely_template_redirect() {
		$layout = blakely_get_theme_layout();

		if ( 'no-sidebar-full-width' === $layout ) {
			$GLOBALS['content_width'] = 1510;
		}
	}
endif;
add_action( 'template_redirect', 'blakely_template_redirect' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function blakely_widgets_init() {
	$args = array(
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	);

	register_sidebar( array(
		'name'        => esc_html__( 'Sidebar', 'blakely' ),
		'id'          => 'sidebar-1',
		'description' => esc_html__( 'Add widgets here.', 'blakely' ),
		) + $args
	);

	register_sidebar( array(
		'name'        => esc_html__( 'Footer 1', 'blakely' ),
		'id'          => 'sidebar-2',
		'description' => esc_html__( 'Add widgets here to appear in your footer.', 'blakely' ),
		) + $args
	);

	register_sidebar( array(
		'name'        => esc_html__( 'Footer 2', 'blakely' ),
		'id'          => 'sidebar-3',
		'description' => esc_html__( 'Add widgets here to appear in your footer.', 'blakely' ),
		) + $args
	);

	register_sidebar( array(
		'name'        => esc_html__( 'Footer 3', 'blakely' ),
		'id'          => 'sidebar-4',
		'description' => esc_html__( 'Add widgets here to appear in your footer.', 'blakely' ),
		) + $args
	);

	if ( class_exists( 'Catch_Instagram_Feed_Gallery_Widget' ) ||  class_exists( 'Catch_Instagram_Feed_Gallery_Widget_Pro' ) ) {
		register_sidebar( array(
			'name'        => esc_html__( 'Instagram', 'blakely' ),
			'id'          => 'sidebar-instagram',
			'description' => esc_html__( 'Appears above footer. This sidebar is only for Widget from plugin Catch Instagram Feed Gallery Widget and Catch Instagram Feed Gallery Widget Pro', 'blakely' ),
			) + $args
		);
	}
}
add_action( 'widgets_init', 'blakely_widgets_init' );

if ( ! function_exists( 'blakely_fonts_url' ) ) :
	/**
	 * Register Google fonts for Blakely
	 *
	 * Create your own blakely_fonts_url() function to override in a child theme.
	 *
	 * @since Blakely 1.0
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function blakely_fonts_url() {
		$fonts_url = '';
	
		/* Translators: If there are characters in your language that are not
		* supported by Open Sans, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$open_sans = _x( 'on', 'Open Sans: on or off', 'blakely' );
	
		/* Translators: If there are characters in your language that are not
		* supported by Poppins, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$opppins = _x( 'on', 'Poppins: on or off', 'blakely' );
	
		/* Translators: If there are characters in your language that are not
		* supported by Courgette, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$courgette = _x( 'on', 'Courgette: on or off', 'blakely' );
		if ( 'off' !== $open_sans || 'off' !== $opppins || 'off' !== $courgette) {
			$font_families = array();
	
			if ( 'off' !== $open_sans ) {
			$font_families[] = 'Open Sans:300,400,600,700';
			}
	
			if ( 'off' !== $opppins ) {
			$font_families[] = 'Poppins:300,400,600,700';
			}
	
			if ( 'off' !== $courgette ) {
			$font_families[] = 'Courgette:300,400,600,700';
			}
			
			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);
	
			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}
	
		return esc_url_raw( $fonts_url );
	}
endif;

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Blakely 1.0
 */
function blakely_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'blakely_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 */
function blakely_scripts() {
	$min  = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	$path = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? 'assets/js/source/' : 'assets/js/';

	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'blakely-fonts', blakely_fonts_url(), array(), null );

	// Theme stylesheet.
	wp_enqueue_style( 'blakely-style', get_stylesheet_uri(), null, date( 'Ymd-Gis', filemtime( get_template_directory() . '/style.css' ) ) );

	// Theme block stylesheet.
	wp_enqueue_style( 'blakely-block-style', get_theme_file_uri( 'assets/css/blocks.css' ), array( 'blakely-style' ), '1.0' );

	// Load the html5 shiv.
	wp_enqueue_script( 'blakely-html5',  get_theme_file_uri( $path . 'html5' . $min . '.js' ), array(), '3.7.3' );
	wp_script_add_data( 'blakely-html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'blakely-skip-link-focus-fix', get_theme_file_uri( $path . 'skip-link-focus-fix' . $min . '.js' ), array(), '201800703', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	$deps[] = 'jquery';

	$enable_portfolio = get_theme_mod( 'blakely_portfolio_option', 'disabled' );

	if ( blakely_check_section( $enable_portfolio ) ){ 
		$deps[] = 'jquery-masonry';
	}

	//Slider Scripts
	$enable_slider      	   = blakely_check_section( get_theme_mod( 'blakely_slider_option', 'disabled' ) );
	$enable_testimonial_slider = blakely_check_section( get_theme_mod( 'blakely_testimonial_option', 'disabled' ) );

	if ( $enable_slider || $enable_testimonial_slider ) {
		// Enqueue owl carousel css. Must load CSS before JS.
		wp_enqueue_style( 'owl-carousel-core', get_theme_file_uri( 'assets/css/owl-carousel/owl.carousel.min.css' ), null, '2.3.4' );
		wp_enqueue_style( 'owl-carousel-default', get_theme_file_uri( 'assets/css/owl-carousel/owl.theme.default.min.css' ), null, '2.3.4' );

		// Enqueue script
		wp_enqueue_script( 'owl-carousel', get_theme_file_uri( $path . 'owl.carousel' . $min . '.js' ), array( 'jquery' ), '2.3.4', true );

		$deps[] = 'owl-carousel';

	}

	wp_enqueue_script( 'blakely-script', get_theme_file_uri( $path . 'functions' . $min . '.js' ), $deps, '201800703', true );

	wp_localize_script( 'blakely-script', 'photoFocusOptions', array(
		'screenReaderText' => array(
			'expand'   => esc_html__( 'expand child menu', 'blakely' ),
			'collapse' => esc_html__( 'collapse child menu', 'blakely' ),
			'icon'     => blakely_get_svg( array(
					'icon'     => 'angle-down',
					'fallback' => true,
				)
			),
		),
		'iconNavPrev'     => blakely_get_svg( array(
				'icon'     => 'angle-left',
				'fallback' => true,
			)
		),
		'iconNavNext'     => blakely_get_svg( array(
				'icon'     => 'angle-right',
				'fallback' => true,
			)
		),
		'rtl' => is_rtl(),
		'dropdownIcon'     => blakely_get_svg( array( 'icon' => 'angle-down', 'fallback' => true ) ),
	) );
}
add_action( 'wp_enqueue_scripts', 'blakely_scripts' );

/**
 * Enqueue editor styles for Gutenberg
 */
function blakely_block_editor_styles() {
	$block_style_url = 'assets/css/editor-blocks.css';

	if ( 'light' === get_theme_mod( 'editor_color_scheme', 'dark' ) ) {
		$block_style_url = 'assets/css/editor-blocks-light.css';
	}

	// Block styles.
	wp_enqueue_style( 'blakely-block-editor-style', get_theme_file_uri( $block_style_url ) );

	// Add custom fonts.
	wp_enqueue_style( 'blakely-fonts', blakely_fonts_url(), array(), null );
}
add_action( 'enqueue_block_editor_assets', 'blakely_block_editor_styles' );

if ( ! function_exists( 'blakely_excerpt_length' ) ) :
	/**
	 * Sets the post excerpt length to n words.
	 *
	 * function tied to the excerpt_length filter hook.
	 * @uses filter excerpt_length
	 *
	 * @since Blakely 1.0
	 */
	function blakely_excerpt_length( $length ) {
		if ( is_admin() ) {
			return $length;
		}

		// Getting data from Customizer Options
		$length	= get_theme_mod( 'blakely_excerpt_length', 30 );

		return absint( $length );
	}
endif; //blakely_excerpt_length
add_filter( 'excerpt_length', 'blakely_excerpt_length', 999 );

if ( ! function_exists( 'blakely_excerpt_more' ) ) :
	/**
	 * Replaces "[...]" (appended to automatically generated excerpts) with ... and a option from customizer
	 *
	 * @return string option from customizer prepended with an ellipsis.
	 */
	function blakely_excerpt_more( $more ) {
		if ( is_admin() ) {
			return $more;
		}

		$more_tag_text = get_theme_mod( 'blakely_excerpt_more_text',  esc_html__( 'Continue reading', 'blakely' ) );

		$link = sprintf( '<p class="more-link"><a class="button" href="%1$s" class="readmore">%2$s</a></p>',
			esc_url( get_permalink() ),
			/* translators: %s: Name of current post */
			wp_kses_data( $more_tag_text ) . '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>'
			);

		return $link;
	}
endif;
add_filter( 'excerpt_more', 'blakely_excerpt_more' );

if ( ! function_exists( 'blakely_more_link' ) ) :
	/**
	 * Replacing Continue reading link to the_content more.
	 *
	 * function tied to the the_content_more_link filter hook.
	 *
	 * @since Blakely 1.0
	 */
	function blakely_more_link( $more_link, $more_link_text ) {
		$more_tag_text = get_theme_mod( 'blakely_excerpt_more_text', esc_html__( 'Continue reading', 'blakely' ) );

		return ' &hellip; ' . str_replace( $more_link_text, wp_kses_data( $more_tag_text ), $more_link );
	}
endif; //blakely_more_link
add_filter( 'the_content_more_link', 'blakely_more_link', 10, 2 );

/**
 * SVG icons functions and filters
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );

/**
 * Implement the Custom Header feature
 */
require get_parent_theme_file_path( '/inc/custom-header.php' );

/**
 * Custom template tags for this theme
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Functions which enhance the theme by hooking into WordPress
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions
 */
require get_parent_theme_file_path( '/inc/customizer/customizer.php' );

/**
 * Color Scheme additions
 */
require get_parent_theme_file_path( '/inc/color-scheme.php' );

/**
 * Load Jetpack compatibility file
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_parent_theme_file_path( '/inc/jetpack.php' );
}

/**
 * Load Social Widgets
 */
require get_parent_theme_file_path( '/inc/widget-social-icons.php' );

/**
 * Load TGMPA
 */
require get_parent_theme_file_path( '/inc/class-tgm-plugin-activation.php' );

/**
 * Load Theme About Page
 */
require get_parent_theme_file_path( '/inc/about.php' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function blakely_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		// Catch Web Tools.
		array(
			'name' => 'Catch Web Tools', // Plugin Name, translation not required.
			'slug' => 'catch-web-tools',
		),
		// Catch IDs
		array(
			'name' => 'Catch IDs', // Plugin Name, translation not required.
			'slug' => 'catch-ids',
		),
		// To Top.
		array(
			'name' => 'To top', // Plugin Name, translation not required.
			'slug' => 'to-top',
		),
		// Catch Gallery.
		array(
			'name' => 'Catch Gallery', // Plugin Name, translation not required.
			'slug' => 'catch-gallery',
		),
	);

	if ( ! class_exists( 'Catch_Infinite_Scroll_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Catch Infinite Scroll', // Plugin Name, translation not required.
			'slug' => 'catch-infinite-scroll',
		);
	}

	if ( ! class_exists( 'Essential_Content_Types_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Essential Content Types', // Plugin Name, translation not required.
			'slug' => 'essential-content-types',
		);
	}

	if ( ! class_exists( 'Essential_Widgets_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Essential Widgets', // Plugin Name, translation not required.
			'slug' => 'essential-widgets',
		);
	}

	if ( ! class_exists( 'Catch_Instagram_Feed_Gallery_Widget_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Catch Instagram Feed Gallery & Widget', // Plugin Name, translation not required.
			'slug' => 'catch-instagram-feed-gallery-widget',
		);
	}

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'blakely',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'blakely_register_required_plugins' );

/**
 * Checks if there are options already present from free version and adds it to the Pro theme options
 *
 * @since Blakely 1.0
 * @hook after_theme_switch
 */
function blakely_setup_options( $old_theme_name ) {
	if ( $old_theme_name ) {
		$old_theme_slug = sanitize_title( $old_theme_name );
		$free_version_slug = array(
			'blakely',
		);

		$pro_version_slug  = 'blakely';

		$free_options = get_option( 'theme_mods_' . $old_theme_slug );

		// Perform action only if theme_mods_photoFocus free version exists.
		if ( in_array( $old_theme_slug, $free_version_slug ) && $free_options && '1' !== get_theme_mod( 'free_pro_migration' ) ) {
			$new_options = wp_parse_args( get_theme_mods(), $free_options );

			if ( update_option( 'theme_mods_' . $pro_version_slug, $free_options ) ) {
				// Set Migration Parameter to true so that this script does not run multiple times.
				set_theme_mod( 'free_pro_migration', '1' );
			}
		}
	}
}
add_action( 'after_switch_theme', 'blakely_setup_options' );

/**
 * Disable WooCommerce CSS.
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
