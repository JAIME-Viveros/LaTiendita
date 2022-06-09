<?php
/**
 * Playlist Options
 *
 * @package Blakely
 */

/**
 * Add sticky_playlist options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function blakely_sticky_playlist( $wp_customize ) {
	$wp_customize->add_section( 'blakely_sticky_playlist', array(
			'title' => esc_html__( 'Sticky Playlist', 'blakely' ),
			'panel' => 'blakely_theme_options',
		)
	);

	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_sticky_playlist_visibility',
			'default'           => 'disabled',
			'sanitize_callback' => 'blakely_sanitize_select',
			'choices'           => blakely_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'blakely' ),
			'section'           => 'blakely_sticky_playlist',
			'type'              => 'select',
		)
	);

	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_sticky_playlist',
			'default'           => '0',
			'sanitize_callback' => 'blakely_sanitize_post',
			'active_callback'   => 'blakely_is_sticky_playlist_active',
			'label'             => esc_html__( 'Page', 'blakely' ),
			'section'           => 'blakely_sticky_playlist',
			'type'              => 'dropdown-pages',
		)
	);

}
add_action( 'customize_register', 'blakely_sticky_playlist', 12 );

/** Active Callback Functions **/
if ( ! function_exists( 'blakely_is_sticky_playlist_active' ) ) :
	/**
	* Return true if sticky_playlist is active
	*
	* @since 1.0
	*/
	function blakely_is_sticky_playlist_active( $control ) {
		$enable = $control->manager->get_setting( 'blakely_sticky_playlist_visibility' )->value();

		return blakely_check_section( $enable );
	}
endif;

