<?php
/**
 * Add WooCommerce Elements in header
 *
 * @package Blakely
 */

if ( ! class_exists( 'WooCommerce' ) ) {
    // Bail if WooCommerce is not installed
    return;
}

if ( get_theme_mod( 'blakely_header_cart_enable', 0 ) && function_exists( 'blakely_header_cart' ) ) {
	blakely_header_cart();
}
