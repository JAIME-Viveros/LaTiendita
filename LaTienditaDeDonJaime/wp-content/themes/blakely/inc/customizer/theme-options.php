<?php
/**
 * Theme Options
 *
 * @package Blakely
 */

/**
 * Add theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function blakely_theme_options( $wp_customize ) {
	$wp_customize->add_panel( 'blakely_theme_options', array(
		'title'    => esc_html__( 'Theme Options', 'blakely' ),
		'priority' => 130,
	) );

	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_latest_posts_title',
			'default'           => esc_html__( 'News', 'blakely' ),
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Latest Posts Title', 'blakely' ),
			'section'           => 'blakely_theme_options',
		)
	);

	// Layout Options
	$wp_customize->add_section( 'blakely_layout_options', array(
		'title' => esc_html__( 'Layout Options', 'blakely' ),
		'panel' => 'blakely_theme_options',
		)
	);

	/* Default Layout */
	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_default_layout',
			'default'           => 'right-sidebar',
			'sanitize_callback' => 'blakely_sanitize_select',
			'label'             => esc_html__( 'Default Layout', 'blakely' ),
			'section'           => 'blakely_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'right-sidebar'         => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'blakely' ),
				'no-sidebar'            => esc_html__( 'No Sidebar', 'blakely' ),
			),
		)
	);

	/* Homepage/Archive Layout */
	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_homepage_archive_layout',
			'default'           => 'right-sidebar',
			'sanitize_callback' => 'blakely_sanitize_select',
			'label'             => esc_html__( 'Homepage/Archive Layout', 'blakely' ),
			'section'           => 'blakely_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'right-sidebar'         => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'blakely' ),
				'no-sidebar'            => esc_html__( 'No Sidebar', 'blakely' ),
			),
		)
	);

	/* Single Page/Post Image */
	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_single_layout',
			'default'           => 'disabled',
			'sanitize_callback' => 'blakely_sanitize_select',
			'label'             => esc_html__( 'Single Page/Post Image', 'blakely' ),
			'section'           => 'blakely_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'disabled'              => esc_html__( 'Disabled', 'blakely' ),
				'post-thumbnail'        => esc_html__( 'Post Thumbnail', 'blakely' ),
			),
		)
	);

	// Excerpt Options.
	$wp_customize->add_section( 'blakely_excerpt_options', array(
		'panel'     => 'blakely_theme_options',
		'title'     => esc_html__( 'Excerpt Options', 'blakely' ),
	) );

	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_excerpt_length',
			'default'           => '20',
			'sanitize_callback' => 'absint',
			'input_attrs' => array(
				'min'   => 10,
				'max'   => 200,
				'step'  => 5,
				'style' => 'width: 60px;',
			),
			'label'    => esc_html__( 'Excerpt Length (words)', 'blakely' ),
			'section'  => 'blakely_excerpt_options',
			'type'     => 'number',
		)
	);

	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_excerpt_more_text',
			'default'           => esc_html__( 'Continue reading', 'blakely' ),
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Read More Text', 'blakely' ),
			'section'           => 'blakely_excerpt_options',
			'type'              => 'text',
		)
	);

	// Excerpt Options.
	$wp_customize->add_section( 'blakely_search_options', array(
		'panel'     => 'blakely_theme_options',
		'title'     => esc_html__( 'Search Options', 'blakely' ),
	) );

	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_search_text',
			'default'           => esc_html__( 'Search', 'blakely' ),
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Search Text', 'blakely' ),
			'section'           => 'blakely_search_options',
			'type'              => 'text',
		)
	);

	// Homepage / Frontpage Options.
	$wp_customize->add_section( 'blakely_homepage_options', array(
		'description' => esc_html__( 'Only posts that belong to the categories selected here will be displayed on the front page', 'blakely' ),
		'panel'       => 'blakely_theme_options',
		'title'       => esc_html__( 'Homepage / Frontpage Options', 'blakely' ),
	) );

	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_recent_posts_heading',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__( 'News', 'blakely' ),
			'label'             => esc_html__( 'Recent Posts Heading', 'blakely' ),
			'section'           => 'blakely_homepage_options',
		)
	);

	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_front_page_category',
			'sanitize_callback' => 'blakely_sanitize_category_list',
			'custom_control'    => 'Blakely_Multi_Cat',
			'label'             => esc_html__( 'Categories', 'blakely' ),
			'section'           => 'blakely_homepage_options',
			'type'              => 'dropdown-categories',
		)
	);
	// Pagination Options.
	$pagination_type = get_theme_mod( 'blakely_pagination_type', 'default' );

	$nav_desc = '';

	/**
	* Check if navigation type is Jetpack Infinite Scroll and if it is enabled
	*/
	$nav_desc = sprintf(
		wp_kses(
			__( 'For infinite scrolling, use %1$sCatch Infinite Scroll Plugin%2$s with Infinite Scroll module Enabled.', 'blakely' ),
			array(
				'a' => array(
					'href' => array(),
					'target' => array(),
				),
				'br'=> array()
			)
		),
		'<a target="_blank" href="https://wordpress.org/plugins/catch-infinite-scroll/">',
		'</a>'
	);

	$wp_customize->add_section( 'blakely_pagination_options', array(
		'description'     => $nav_desc,
		'panel'           => 'blakely_theme_options',
		'title'           => esc_html__( 'Pagination Options', 'blakely' ),
		'active_callback' => 'blakely_scroll_plugins_inactive'
	) );

	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_pagination_type',
			'default'           => 'default',
			'sanitize_callback' => 'blakely_sanitize_select',
			'choices'           => blakely_get_pagination_types(),
			'label'             => esc_html__( 'Pagination type', 'blakely' ),
			'section'           => 'blakely_pagination_options',
			'type'              => 'select',
		)
	);

	/* Scrollup Options */
	$wp_customize->add_section( 'blakely_scrollup', array(
		'panel'    => 'blakely_theme_options',
		'title'    => esc_html__( 'Scrollup Options', 'blakely' ),
	) );

	$action = 'install-plugin';
	$slug   = 'to-top';

	$install_url = wp_nonce_url(
	    add_query_arg(
	        array(
	            'action' => $action,
	            'plugin' => $slug
	        ),
	        admin_url( 'update.php' )
	    ),
	    $action . '_' . $slug
	);

	// Add note to Scroll up Section
    blakely_register_option( $wp_customize, array(
            'name'              => 'blakely_to_top_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Blakely_Note_Control',
            'active_callback'   => 'blakely_is_to_top_inactive',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
            'label'             => sprintf( esc_html__( 'For Scroll Up, install %1$sTo Top%2$s Plugin', 'blakely' ),
                '<a target="_blank" href="' . esc_url( $install_url ) . '">',
                '</a>'

            ),
           'section'            => 'blakely_scrollup',
            'type'              => 'description',
            'priority'          => 1,
        )
    );
}
add_action( 'customize_register', 'blakely_theme_options' );

/** Active Callback Functions */

if ( ! function_exists( 'blakely_scroll_plugins_inactive' ) ) :
	/**
	* Return true if infinite scroll functionality exists
	*
	* @since Blakely 1.0
	*/
	function blakely_scroll_plugins_inactive( $control ) {
		if ( ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) || class_exists( 'Catch_Infinite_Scroll' ) ) {
			// Support infinite scroll plugins.
			return false;
		}

		return true;
	}
endif;

if ( ! function_exists( 'blakely_is_static_page_enabled' ) ) :
	/**
	* Return true if A Static Page is enabled
	*
	* @since Blakely 1.1.2
	*/
	function blakely_is_static_page_enabled( $control ) {
		$enable = $control->manager->get_setting( 'show_on_front' )->value();
		if ( 'page' === $enable ) {
			return true;
		}
		return false;
	}
endif;

if ( ! function_exists( 'blakely_is_to_top_inactive' ) ) :
    /**
    * Return true if featured_content is active
    *
    * @since Blakely 0.1
    */
    function blakely_is_to_top_inactive( $control ) {
        return ! ( class_exists( 'To_Top' ) );
    }
endif;