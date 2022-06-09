<?php
/**
 * Adding support for WooCommerce Products Showcase Option
 */

if ( ! class_exists( 'WooCommerce' ) ) {
    // Bail if WooCommerce is not installed
    return;
}

/**
 * Add WooCommerce Product Showcase Options to customizer
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function blakely_woo_products( $wp_customize ) {
   $wp_customize->add_section( 'blakely_woo_products', array(
        'title' => esc_html__( 'WooCommerce Products Showcase', 'blakely' ),
        'panel' => 'blakely_theme_options',
    ) );

    blakely_register_option( $wp_customize, array(
            'name'              => 'blakely_woo_products_option',
            'default'           => 'disabled',
            'sanitize_callback' => 'blakely_sanitize_select',
            'choices'           => blakely_section_visibility_options(),
            'label'             => esc_html__( 'Enable on', 'blakely' ),
            'section'           => 'blakely_woo_products',
            'type'              => 'select',
        )
    );

    blakely_register_option( $wp_customize, array(
            'name'              => 'blakely_woo_products_image',
            'sanitize_callback' => 'blakely_sanitize_image',
            'custom_control'    => 'WP_Customize_Image_Control',
            'active_callback'   => 'blakely_is_rps_active',
            'label'             => esc_html__( 'Background Image', 'blakely' ),
            'section'           => 'blakely_woo_products',
        )
    );

    blakely_register_option( $wp_customize, array(
            'name'              => 'blakely_woo_products_opacity',
            'default'           => '70',
            'sanitize_callback' => 'blakely_sanitize_number_range',
            'active_callback'   => 'blakely_is_rps_active',
            'label'             => esc_html__( 'Background Image Overlay', 'blakely' ),
            'section'           => 'blakely_woo_products',
            'type'              => 'number',
            'input_attrs'       => array(
                'style' => 'width: 60px;',
                'min'   => 0,
                'max'   => 100,
            ),
        )
    );

    blakely_register_option( $wp_customize, array(
            'name'              => 'blakely_woo_products_headline',
            'default'           => esc_html__( 'Products Showcase', 'blakely' ),
            'sanitize_callback' => 'wp_kses_post',
            'label'             => esc_html__( 'Headline', 'blakely' ),
            'active_callback'   => 'blakely_is_rps_active',
            'section'           => 'blakely_woo_products',
            'type'              => 'text',
        )
    );

    blakely_register_option( $wp_customize, array(
            'name'              => 'blakely_woo_products_subheadline',
            'default'           => esc_html__( 'This season\'s top sold products', 'blakely' ),
            'sanitize_callback' => 'wp_kses_post',
            'label'             => esc_html__( 'Sub headline', 'blakely' ),
            'active_callback'   => 'blakely_is_rps_active',
            'section'           => 'blakely_woo_products',
            'type'              => 'text',
        )
    );

    blakely_register_option( $wp_customize, array(
            'name'              => 'blakely_woo_products_number',
            'default'           => 3,
            'sanitize_callback' => 'blakely_sanitize_number_range',
            'active_callback'   => 'blakely_is_rps_active',
            'description'       => esc_html__( 'Save and refresh the page if No. of Products is changed. Set -1 to display all', 'blakely' ),
            'input_attrs'       => array(
                'style' => 'width: 50px;',
                'min'   => -1,
            ),
            'label'             => esc_html__( 'No of Products', 'blakely' ),
            'section'           => 'blakely_woo_products',
            'type'              => 'number',
        )
    );

    blakely_register_option( $wp_customize, array(
            'name'               => 'blakely_woo_products_columns',
            'default'            => 3,
            'sanitize_callback'  => 'blakely_sanitize_number_range',
            'active_callback'    => 'blakely_is_rps_active',
            'description'        => esc_html__( 'Theme supports up to 4 columns', 'blakely' ),
            'label'              => esc_html__( 'No of Columns', 'blakely' ),
            'section'            => 'blakely_woo_products',
            'type'               => 'number',
            'input_attrs'       => array(
                'style' => 'width: 50px;',
                'min'   => 1,
                'max'   => 4,
            ),
        )
    );

    blakely_register_option( $wp_customize, array(
            'name'               => 'blakely_woo_products_paginate',
            'default'            => 'false',
            'sanitize_callback'  => 'blakely_sanitize_select',
            'active_callback'    => 'blakely_is_rps_active',
            'label'              => esc_html__( 'Paginate', 'blakely' ),
            'section'            => 'blakely_woo_products',
            'type'               => 'radio',
            'choices'            => array(
                'false' => esc_html__( 'No', 'blakely' ),
                'true' => esc_html__( 'Yes', 'blakely' ),
            ),
        )
    );

    blakely_register_option( $wp_customize, array(
            'name'               => 'blakely_woo_products_orderby',
            'default'            => 'date',
            'sanitize_callback'  => 'blakely_sanitize_select',
            'active_callback'    => 'blakely_is_rps_active',
            'label'              => esc_html__( 'Order By', 'blakely' ),
            'section'            => 'blakely_woo_products',
            'type'               => 'select',
            'choices'            => array(
                'date'       => esc_html__( 'Date - The date the product was published', 'blakely' ),
                'id'         => esc_html__( 'ID - The post ID of the product', 'blakely' ),
                'menu_order' => esc_html__( 'Menu Order - The Menu Order, if set (lower numbers display first)', 'blakely' ),
                'popularity' => esc_html__( 'Popularity - The number of purchases', 'blakely' ),
                'rand'       => esc_html__( 'Random', 'blakely' ),
                'rating'     => esc_html__( 'Rating - The average product rating', 'blakely' ),
                'title'      => esc_html__( 'Title - The product title', 'blakely' ),
            ),
        )
    );

    blakely_register_option( $wp_customize, array(
            'name'               => 'blakely_woo_products_products_filter',
            'default'            => 'none',
            'sanitize_callback'  => 'blakely_sanitize_select',
            'active_callback'    => 'blakely_is_rps_active',
            'label'              => esc_html__( 'Products Filter', 'blakely' ),
            'section'            => 'blakely_woo_products',
            'type'               => 'radio',
            'choices'            => array(
                'none'         => esc_html__( 'None', 'blakely' ),
                'on_sale'      => esc_html__( 'Retrieve on sale products', 'blakely' ),
                'best_selling' => esc_html__( 'Retrieve best selling products', 'blakely' ),
                'top_rated'    => esc_html__( 'Retrieve top rated products', 'blakely' ),
            ),
        )
    );

    blakely_register_option( $wp_customize, array(
            'name'              => 'blakely_woo_products_featured',
            'sanitize_callback' => 'blakely_sanitize_checkbox',
            'active_callback'   => 'blakely_is_rps_active',
            'label'             => esc_html__( 'Show only Products that are marked as Featured Products', 'blakely' ),
            'section'           => 'blakely_woo_products',
            'custom_control'    => 'Blakely_Toggle_Control',
        )
    );

    blakely_register_option( $wp_customize, array(
            'name'               => 'blakely_woo_products_order',
            'default'            => 'DESC',
            'sanitize_callback'  => 'blakely_sanitize_select',
            'active_callback'    => 'blakely_is_rps_active',
            'label'              => esc_html__( 'Order', 'blakely' ),
            'section'            => 'blakely_woo_products',
            'type'               => 'radio',
            'choices'            => array(
                'ASC'  => esc_html__( 'Ascending', 'blakely' ),
                'DESC' => esc_html__( 'Descending', 'blakely' ),
            ),
        )
    );

    blakely_register_option( $wp_customize, array(
            'name'              => 'blakely_woo_products_skus',
            'description'       => esc_html__( 'Comma separated list of product SKUs', 'blakely' ),
            'sanitize_callback' => 'sanitize_text_field',
            'active_callback'   => 'blakely_is_rps_active',
            'label'             => esc_html__( 'SKUs', 'blakely' ),
            'section'           => 'blakely_woo_products',
            'type'              => 'text',
        )
    );

    blakely_register_option( $wp_customize, array(
            'name'              => 'blakely_woo_products_category',
            'description'       => esc_html__( 'Comma separated list of category slugs', 'blakely' ),
            'sanitize_callback' => 'sanitize_text_field',
            'active_callback'   => 'blakely_is_rps_active',
            'label'             => esc_html__( 'Category', 'blakely' ),
            'section'           => 'blakely_woo_products',
            'type'              => 'textarea',
        )
    );

    blakely_register_option( $wp_customize, array(
            'name'               => 'blakely_woo_products_atc_button_style',
            'default'            => 'hover-add-to-cart',
            'sanitize_callback'  => 'blakely_sanitize_select',
            'active_callback'    => 'blakely_is_rps_active',
            'label'              => esc_html__( 'Add to Cart Button Style', 'blakely' ),
            'section'            => 'blakely_woo_products',
            'type'               => 'radio',
            'choices'            => array(
                'hover-add-to-cart'       => esc_html__( 'Hover on Product Image', 'blakely' ),
                'traditional-add-to-cart' => esc_html__( 'Traditional(Below Price/Rating)', 'blakely' ),
            ),
        )
    );

    blakely_register_option( $wp_customize, array(
            'name'              => 'blakely_woo_products_text',
            'sanitize_callback' => 'sanitize_text_field',
            'active_callback'   => 'blakely_is_rps_active',
            'label'             => esc_html__( 'Button Text', 'blakely' ),
            'section'           => 'blakely_woo_products',
            'type'              => 'text',
        )
    );

    $shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
    blakely_register_option( $wp_customize, array(
            'name'              => 'blakely_woo_products_link',
            'default'           =>  esc_url( $shop_page_url ),
            'sanitize_callback' => 'esc_url_raw',
            'active_callback'   => 'blakely_is_rps_active',
            'label'             => esc_html__( 'Button Link', 'blakely' ),
            'section'           => 'blakely_woo_products',
        )
    );

    blakely_register_option( $wp_customize, array(
            'name'              => 'blakely_woo_products_target',
            'sanitize_callback' => 'blakely_sanitize_checkbox',
            'active_callback'   => 'blakely_is_rps_active',
            'label'             => esc_html__( 'Open Link in New Window/Tab', 'blakely' ),
            'section'           => 'blakely_woo_products',
            'custom_control'    => 'Blakely_Toggle_Control',
        )
    );
}
add_action( 'customize_register', 'blakely_woo_products', 10 );

/** Active Callback Functions **/
if( ! function_exists( 'blakely_is_rps_active' ) ) :
    /**
    * Return true if featured content is active
    *
    * @since Catch_Store Pro 1.0
    */
    function blakely_is_rps_active( $control ) {
        $enable = $control->manager->get_setting( 'blakely_woo_products_option' )->value();

        return ( blakely_check_section( $enable ) );
    }
endif;
