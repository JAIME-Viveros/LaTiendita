<?php
/**
 * Hero Content Options
 *
 * @package Blakely
 */

/**
 * Add hero content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function blakely_hero_content_options( $wp_customize ) {
	$wp_customize->add_section( 'blakely_hero_content_options', array(
			'title' => esc_html__( 'Hero Content', 'blakely' ),
			'panel' => 'blakely_theme_options',
		)
	);

	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_hero_content_visibility',
			'default'           => 'disabled',
			'sanitize_callback' => 'blakely_sanitize_select',
			'choices'           => blakely_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'blakely' ),
			'section'           => 'blakely_hero_content_options',
			'type'              => 'select',
		)
	);

	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_hero_content',
			'default'           => '0',
			'sanitize_callback' => 'blakely_sanitize_post',
			'active_callback'   => 'blakely_is_hero_content_active',
			'label'             => esc_html__( 'Page', 'blakely' ),
			'section'           => 'blakely_hero_content_options',
			'type'              => 'dropdown-pages',
		)
	);

	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_hero_content_sub_title',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'blakely_is_hero_content_active',
			'label'             => esc_html__( 'Sub Headline', 'blakely' ),
			'section'           => 'blakely_hero_content_options',
			'type'              => 'textarea',
		)
	);
}
add_action( 'customize_register', 'blakely_hero_content_options' );

/** Active Callback Functions **/
if ( ! function_exists( 'blakely_is_hero_content_active' ) ) :
	/**
	* Return true if hero content is active
	*
	* @since Blakely 1.0
	*/
	function blakely_is_hero_content_active( $control ) {
		$enable = $control->manager->get_setting( 'blakely_hero_content_visibility' )->value();

		return blakely_check_section( $enable );
	}
endif;