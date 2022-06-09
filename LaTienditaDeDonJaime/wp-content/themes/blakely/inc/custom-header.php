<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Blakely
 */

if ( ! function_exists( 'blakely_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see blakely_custom_header_setup().
	 */
	function blakely_header_style() {
		$header_image = blakely_featured_overall_image();

	    if ( 'disable' !== $header_image ) :
	    	/**
	    	 * Image Position CSS
	    	 */
			$image_position_mobile  = get_theme_mod( 'blakely_header_media_image_position_mobile', 'center center' );
			$image_position_desktop = get_theme_mod( 'blakely_header_media_image_position_desktop' , 'center center' );

			?>
	        <style type="text/css" rel="header-image">
	            .custom-header .wrapper:before {
	                background-image: url( <?php echo esc_url( $header_image ); ?>);
	                <?php if ( 'center center' !== $image_position_mobile ) : ?>
					background-position: <?php echo esc_attr( $image_position_mobile ); ?>;
					<?php endif; ?>
					background-repeat: no-repeat;
					background-size: cover;
	            }

	            <?php if ( 'center center' !== $image_position_desktop ) : ?>
	            @media only screen and (min-width: 64em) {
					.custom-header .wrapper:before {
						background-position: <?php echo esc_attr( $image_position_desktop ); ?>;
					}
				}
				<?php endif; ?>
	        </style>
	    <?php
	    endif;

	    $header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
		?>
			.site-title a,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
			// If the user has set a custom color for the text use that.
			else :
		?>
			.absolute-header .site-title a,
			.absolute-header .site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;

if ( ! function_exists( 'blakely_featured_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 *
	 * To override this in a child theme
	 * simply create your own blakely_featured_image(), and that function will be used instead.
	 *
	 * @since Blakely 1.0
	 */
	function blakely_featured_image() {
		if ( is_header_video_active() && has_header_video() ) {
			return true;
		}
		$thumbnail = 'post-thumbnail';

		if ( is_post_type_archive( 'jetpack-testimonial' ) ) {
			$jetpack_options = get_theme_mod( 'jetpack_testimonials' );
			$option = 'jetpack_testimonial_featured_image';
			$featured_image = get_option( 'jetpack_testimonial_featured_image' );
			if ( isset( $jetpack_options['featured-image'] ) && '' !== $jetpack_options['featured-image'] ) {
				$image = wp_get_attachment_image_src( (int) $jetpack_options['featured-image'], $thumbnail );
				return $image['0'];
			} elseif ( ! isset( $jetpack_options['featured-image'] ) && isset( $featured_image ) && '' !== $featured_image ) {
				$image = wp_get_attachment_image_src( (int) $featured_image, $thumbnail );
				return $image['0'];
			} else {
				return false;
			}
		} elseif ( is_post_type_archive( 'jetpack-portfolio' ) || is_post_type_archive( 'featured-content' ) || is_post_type_archive( 'ect-service' ) || is_post_type_archive( 'ect-team' ) || is_post_type_archive( 'ect-event' ) ) {
			$option = '';

			if ( is_post_type_archive( 'jetpack-portfolio' ) ) {
				$option = 'jetpack_portfolio_featured_image';
			} elseif ( is_post_type_archive( 'featured-content' ) ) {
				$option = 'featured_content_featured_image';
			} elseif ( is_post_type_archive( 'ect-service' ) ) {
				$option = 'ect_service_featured_image';
			} elseif ( is_post_type_archive( 'ect-team' ) ) {
				$option = 'ect_team_featured_image';
			} elseif ( is_post_type_archive( 'ect-event' ) ) {
				$option = 'ect_event_featured_image';
			}

			$featured_image = get_option( $option );

			if ( '' !== $featured_image ) {
				$image = wp_get_attachment_image_src( (int) $featured_image, $thumbnail );
				return isset( $image[0] ) ? $image[0] : false;
			} else {
				return get_header_image();
			}
		} else {
			return get_header_image();
		}
	} // blakely_featured_image
endif;

if ( ! function_exists( 'blakely_featured_page_post_image' ) ) :
	/**
	 * Template for Featured Header Image from Post and Page
	 *
	 * To override this in a child theme
	 * simply create your own blakely_featured_imaage_pagepost(), and that function will be used instead.
	 *
	 * @since Blakely 1.0
	 */
	function blakely_featured_page_post_image() {
		$thumbnail = 'blakely-single-post-page';

		if ( class_exists( 'WooCommerce' ) && is_shop() ) {
			if ( ! has_post_thumbnail( absint( get_option( 'woocommerce_shop_page_id' ) ) ) ) {
				return blakely_featured_image();
			}
		} elseif ( is_home() && $blog_id = get_option('page_for_posts') ) {
			if ( has_post_thumbnail( $blog_id  ) ) {
		    	return get_the_post_thumbnail_url( $blog_id, $thumbnail );
			} else {
				return  blakely_featured_image();
			}
		} elseif ( ! has_post_thumbnail() ) {
			return  blakely_featured_image();
		} elseif ( is_home() && is_front_page() ) {
			return  blakely_featured_image();
		}

		$shop_header = get_theme_mod( 'blakely_shop_page_header_image' );
		if ( class_exists( 'WooCommerce' ) && is_shop() ) {
			return get_the_post_thumbnail_url( absint( get_option( 'woocommerce_shop_page_id' ) ), $thumbnail );
		}elseif ( class_exists( 'WooCommerce' ) && is_product () ) {
			if (  $shop_header ){
			return get_the_post_thumbnail_url( get_the_id(), $thumbnail );
			}
		}else {
			return get_the_post_thumbnail_url( get_the_id(), $thumbnail );
		}
	} // blakely_featured_page_post_image
endif;

if ( ! function_exists( 'blakely_featured_overall_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 *
	 * To override this in a child theme
	 * simply create your own blakely_featured_pagepost_image(), and that function will be used instead.
	 *
	 * @since Blakely 1.0
	 */
	function blakely_featured_overall_image() {
		global $post;
		$enable = get_theme_mod( 'blakely_header_media_option', 'entire-site' );

		// Check Enable/Disable header image in Page/Post Meta box
		if ( is_singular() ) {
			//Individual Page/Post Image Setting
			$individual_featured_image = get_post_meta( $post->ID, 'blakely-single-post-page', true );

			if ( 'disable' === $enable ) {
				return 'disable' ;
			}
		}

		// Check Homepage
		if ( 'homepage' === $enable ) {
			if ( is_front_page() ) {
				return blakely_featured_image();
			}
		}  elseif ( 'entire-site' === $enable ) {
			// Check Entire Site
			return blakely_featured_image();
		}  

		return 'disable';
	} // blakely_featured_overall_image
endif;

if ( ! function_exists( 'blakely_header_media_text' ) ):
	/**
	 * Display Header Media Text
	 *
	 * @since Blakely 1.0
	 */
	function blakely_header_media_text() {

		if ( ! blakely_has_header_media_text() ) {
			// Bail early if header media text is disabled on front page
			return get_header_image();
		}


		$header_media_logo = get_theme_mod( 'blakely_header_media_logo' );

		$classes = array();
		if( is_front_page() ) {
			$classes[] = 'content-align-center';
			$classes[] = 'text-align-center';
		}

		?>
		<div class="custom-header-content sections header-media-section <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
			<div class="custom-header-content-wrapper">
				<?php
				$header_media_subtitle = get_theme_mod( 'blakely_header_media_sub_title' );
				$enable_homepage_logo = get_theme_mod( 'blakely_header_media_logo_option', 'homepage' );

				if( is_front_page() ) : ?>
					<div class="section-subtitle"> <?php echo esc_html( $header_media_subtitle ); ?> </div>
				<?php endif;

				if ( blakely_check_section( $enable_homepage_logo ) && $header_media_logo ) {  ?>
					<div class="site-header-logo">
						<img src="<?php echo esc_url( $header_media_logo ); ?>" title="<?php echo esc_url( home_url( '/' ) ); ?>" />
					</div><!-- .site-header-logo -->
				<?php } ?>

				<?php
				$tag = 'h2';

				if ( is_singular() || is_404() ) {
					$tag = 'h1';
				}

				blakely_header_title( '<div class="section-title-wrapper"><' . $tag . ' class="section-title entry-title">', '</' . $tag . '></div>' );
				?>

				<?php blakely_header_description( '<div class="site-header-text">', '</div>' ); ?>

				<?php if ( is_front_page() ) :
					$header_media_url_text = get_theme_mod( 'blakely_header_media_url_text' );
					
					if ( $header_media_url_text ) : 
						$header_media_url = get_theme_mod( 'blakely_header_media_url', '#' );
						?>
						<span class="more-link">
							<a href="<?php echo esc_url( $header_media_url ); ?>" target="<?php echo esc_attr( get_theme_mod( 'blakely_header_url_target' ) ? '_blank' : '_self' ); ?>" class="readmore"><?php echo esc_html( $header_media_url_text ); ?></a>
						</span>
					<?php endif;
				endif; ?>
			</div><!-- .custom-header-content-wrapper -->
		</div><!-- .custom-header-content -->
		<?php
	} // blakely_header_media_text.
endif;

if ( ! function_exists( 'blakely_has_header_media_text' ) ):
	/**
	 * Return Header Media Text fro front page
	 *
	 * @since Blakely 1.0
	 */
	function blakely_has_header_media_text() {
		$header_image = blakely_featured_overall_image();

		if ( is_front_page() ) {
			$header_media_logo     = get_theme_mod( 'blakely_header_media_logo' );
			$header_media_title    = get_theme_mod( 'blakely_header_media_title' );
			$header_media_text     = get_theme_mod( 'blakely_header_media_text' );
			$header_media_url      = get_theme_mod( 'blakely_header_media_url', '#' );
			$header_media_url_text = get_theme_mod( 'blakely_header_media_url_text' );

			if ( ! $header_media_logo && ! $header_media_title && ! $header_media_text && ! $header_media_url && ! $header_media_url_text ) {
				// Bail early if header media text is disabled
				return false;
			}
		} elseif ( 'disable' === $header_image ) {
			return false;
		}

		return true;
	} // blakely_has_header_media_text.
endif;

if ( ! function_exists( 'blakely_header_title' ) ) :
	/**
	 * Display header media text
	 */
	function blakely_header_title( $before = '', $after = '' ) {
		if ( is_front_page() ) {
			$header_media_title = get_theme_mod( 'blakely_header_media_title' );
			if ( $header_media_title ) {
				echo $before . wp_kses_post( $header_media_title ) . $after;
			}
		} elseif ( is_singular() ) {
			if ( is_page() ) {
				the_title( $before, $after );
			} else {
				the_title( $before, $after );
			}
		} elseif ( is_404() ) {
			echo $before . esc_html__( 'Nothing Found', 'blakely' ) . $after;
		} elseif ( is_search() ) {
			/* translators: %s: search query. */
			echo $before . sprintf( esc_html__( 'Search Results for: %s', 'blakely' ), '<span>' . get_search_query() . '</span>' ) . $after;
		} elseif( class_exists( 'WooCommerce' ) && is_woocommerce() ) {
			echo $before . esc_html( woocommerce_page_title( false ) ) . $after;
		}
		else {
			the_archive_title( $before, $after );
		}
	}
endif;

if ( ! function_exists( 'blakely_header_description' ) ) :
	/**
	 * Display header media description
	 */
	function blakely_header_description( $before = '', $after = '' ) {
		if ( is_front_page() ) {
			echo $before . '<p>' . wp_kses_post( get_theme_mod( 'blakely_header_media_text' ) ) . '</p>' . $after;
		} elseif ( is_singular() && ! is_page() ) {
			echo $before . '<div class="entry-header"><div class="entry-meta">';
				blakely_posted_on();
			echo '</div><!-- .entry-meta --></div>' . $after;
		} elseif ( is_404() ) {
			echo $before . '<p>' . esc_html__( 'Oops! That page can&rsquo;t be found', 'blakely' ) . '</p>' . $after;
		} else {
			the_archive_description( $before, $after );
		}
	}
endif;

/**
 * Customize video play/pause button in the custom header.
 */
function blakely_video_controls( $settings ) {
	$settings['l10n']['play'] = '<span class="screen-reader-text">' . esc_html__( 'Play background video', 'blakely' ) . '</span>' . blakely_get_svg( array( 'icon' => 'play' ) );
	$settings['l10n']['pause'] = '<span class="screen-reader-text">' . esc_html__( 'Pause background video', 'blakely' ) . '</span>' . blakely_get_svg( array( 'icon' => 'pause' ) );
	return $settings;
}
add_filter( 'header_video_settings', 'blakely_video_controls' );
