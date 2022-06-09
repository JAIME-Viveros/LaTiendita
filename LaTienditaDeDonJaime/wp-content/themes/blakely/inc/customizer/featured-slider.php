<?php
/**
 * Featured Slider Options
 *
 * @package Blakely
 */

/**
 * Add hero content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function blakely_slider_options( $wp_customize ) {
	$wp_customize->add_section( 'blakely_featured_slider', array(
			'panel' => 'blakely_theme_options',
			'title' => esc_html__( 'Featured Slider', 'blakely' ),
		)
	);

	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_slider_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'blakely_sanitize_select',
			'choices'           => blakely_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'blakely' ),
			'section'           => 'blakely_featured_slider',
			'type'              => 'select',
		)
	);

	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_slider_number',
			'default'           => '4',
			'sanitize_callback' => 'blakely_sanitize_number_range',

			'active_callback'   => 'blakely_is_slider_active',
			'description'       => esc_html__( 'Save and refresh the page if No. of Slides is changed (Max no of slides is 20)', 'blakely' ),
			'input_attrs'       => array(
				'style' => 'width: 100px;',
				'min'   => 0,
				'max'   => 20,
				'step'  => 1,
			),
			'label'             => esc_html__( 'No of Slides', 'blakely' ),
			'section'           => 'blakely_featured_slider',
			'type'              => 'number',
		)
	);

	$slider_number = get_theme_mod( 'blakely_slider_number', 4 );

	for ( $i = 1; $i <= $slider_number ; $i++ ) {
		blakely_register_option( $wp_customize, array(
				'name'              => 'blakely_slider_page_' . $i,
				'sanitize_callback' => 'blakely_sanitize_post',
				'active_callback'   => 'blakely_is_slider_active',
				'label'             => esc_html__( 'Page', 'blakely' ) . ' # ' . $i,
				'section'           => 'blakely_featured_slider',
				'type'              => 'dropdown-pages',
			)
		);
	} // End for().
}
add_action( 'customize_register', 'blakely_slider_options' );

/** Active Callback Functions */

if ( ! function_exists( 'blakely_is_slider_active' ) ) :
	/**
	* Return true if slider is active
	*
	* @since Blakely 1.0
	*/
	function blakely_is_slider_active( $control ) {
		$enable = $control->manager->get_setting( 'blakely_slider_option' )->value();

		//return true only if previwed page on customizer matches the type option selected
		return blakely_check_section( $enable );
	}
endif;