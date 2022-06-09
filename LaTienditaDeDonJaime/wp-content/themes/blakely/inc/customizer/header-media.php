<?php
/**
 * Header Media Options
 *
 * @package Blakely
 */

/**
 * Add Header Media options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function blakely_header_media_options( $wp_customize ) {
	$wp_customize->get_section( 'header_image' )->description = esc_html__( 'If you add video, it will only show up on Homepage/FrontPage. Other Pages will use Header/Post/Page Image depending on your selection of option. Header Image will be used as a fallback while the video loads ', 'blakely' );

	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_header_media_option',
			'default'           => 'entire-site',
			'sanitize_callback' => 'blakely_sanitize_select',
			'choices'           => array(
				'homepage'               => esc_html__( 'Homepage / Frontpage', 'blakely' ),
				'entire-site'            => esc_html__( 'Entire Site', 'blakely' ),
				'disable'                => esc_html__( 'Disabled', 'blakely' ),
			),
			'label'             => esc_html__( 'Enable on', 'blakely' ),
			'section'           => 'header_image',
			'type'              => 'select',
			'priority'          => 1,
		)
	);

	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_header_media_image_position_desktop',
			'default'           => 'center center',
			'sanitize_callback' => 'blakely_sanitize_select',
			'label'             => esc_html__( 'Image Position (Desktop View)', 'blakely' ),
			'section'           => 'header_image',
			'type'              => 'select',
			'choices'           => array(
				'left top'      => esc_html__( 'Left Top', 'blakely' ),
				'left center'   => esc_html__( 'Left Center', 'blakely' ),
				'left bottom'   => esc_html__( 'Left Bottom', 'blakely' ),
				'right top'     => esc_html__( 'Right Top', 'blakely' ),
				'right center'  => esc_html__( 'Right Center', 'blakely' ),
				'right bottom'  => esc_html__( 'Right Bottom', 'blakely' ),
				'center top'    => esc_html__( 'Center Top', 'blakely' ),
				'center center' => esc_html__( 'Center Center', 'blakely' ),
				'center bottom' => esc_html__( 'Center Bottom', 'blakely' ),
			),
		)
	);

	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_header_media_image_position_mobile',
			'default'           => 'center center',
			'sanitize_callback' => 'blakely_sanitize_select',
			'label'             => esc_html__( 'Image Position (Mobile View)', 'blakely' ),
			'section'           => 'header_image',
			'type'              => 'select',
			'choices'           => array(
				'left top'      => esc_html__( 'Left Top', 'blakely' ),
				'left center'   => esc_html__( 'Left Center', 'blakely' ),
				'left bottom'   => esc_html__( 'Left Bottom', 'blakely' ),
				'right top'     => esc_html__( 'Right Top', 'blakely' ),
				'right center'  => esc_html__( 'Right Center', 'blakely' ),
				'right bottom'  => esc_html__( 'Right Bottom', 'blakely' ),
				'center top'    => esc_html__( 'Center Top', 'blakely' ),
				'center center' => esc_html__( 'Center Center', 'blakely' ),
				'center bottom' => esc_html__( 'Center Bottom', 'blakely' ),
			),
		)
	);

	/*Overlay Option for Header Media*/
	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_header_media_image_opacity',
			'default'           => '0',
			'sanitize_callback' => 'blakely_sanitize_number_range',
			'label'             => esc_html__( 'Header Media Overlay', 'blakely' ),
			'section'           => 'header_image',
			'type'              => 'number',
			'input_attrs'       => array(
				'style' => 'width: 60px;',
				'min'   => 0,
				'max'   => 100,
			),
		)
		);

	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_header_media_logo',
			'sanitize_callback' => 'esc_url_raw',
			'custom_control'    => 'WP_Customize_Image_Control',
			'label'             => esc_html__( 'Header Media Logo', 'blakely' ),
			'section'           => 'header_image',
		)
	);

	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_header_media_logo_option',
			'default'           => 'homepage',
			'sanitize_callback' => 'blakely_sanitize_select',
			'active_callback'   => 'blakely_is_header_media_logo_active',
			'choices'           => array(
				'homepage'               => esc_html__( 'Homepage / Frontpage', 'blakely' ),
				'entire-site'            => esc_html__( 'Entire Site', 'blakely' ) ),
			'label'             => esc_html__( 'Enable Header Media logo on', 'blakely' ),
			'section'           => 'header_image',
			'type'              => 'select',
		)
	);

	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_header_media_sub_title',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Header Media Tagline', 'blakely' ),
			'section'           => 'header_image',
			'type'              => 'text',
		)
	);

    blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_header_media_title',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Header Media Title', 'blakely' ),
			'section'           => 'header_image',
			'type'              => 'text',
		)
	);

	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_header_media_text',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Site Header Text', 'blakely' ),
			'section'           => 'header_image',
			'type'              => 'textarea',
		)
	);

	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_header_media_url',
			'default'           => '#',
			'sanitize_callback' => 'esc_url_raw',
			'label'             => esc_html__( 'Header Media Url', 'blakely' ),
			'section'           => 'header_image',
		)
	);

	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_header_media_url_text',
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Header Media Url Text', 'blakely' ),
			'section'           => 'header_image',
		)
	);

	blakely_register_option( $wp_customize, array(
			'name'              => 'blakely_header_url_target',
			'sanitize_callback' => 'blakely_sanitize_checkbox',
			'label'             => esc_html__( 'Open Link in New Window/Tab', 'blakely' ),
			'section'           => 'header_image',
			'custom_control'    => 'Blakely_Toggle_Control',
		)
	);
}
add_action( 'customize_register', 'blakely_header_media_options' );

/** Active Callback Functions */

if ( ! function_exists( 'blakely_is_header_media_logo_active' ) ) :
	/**
	* Return true if header logo is active
	*
	* @since Blakely 1.0
	*/
	function blakely_is_header_media_logo_active( $control ) {
		$logo = $control->manager->get_setting( 'blakely_header_media_logo' )->value();
		if ( '' != $logo ) {
			return true;
		} else {
			return false;
		}
	}
endif;
