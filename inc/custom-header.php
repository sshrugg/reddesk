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
 * @package Red_Desk_Electric
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses reddesk_header_style()
 */
function reddesk_custom_header_setup() {
	add_theme_support(
		'custom-header',
		apply_filters(
			'reddesk_custom_header_args',
			array(
				'default-image'      => get_template_directory_uri() . '/images/white_stripe.jpg',
                                'default-background-color' => 'F4F0ED',
				'default-text-color' => '290C0E',
				'width'              => 1000,
				'height'             => 250,
				'flex-height'        => true,
                            	'flex-width'        => true,
				'wp-head-callback'   => 'reddesk_header_style',
			)
		)
	);
}

/**
 * Register the default header image
 */
register_default_headers( array(
    'default-image' => array(
        'url'           => get_stylesheet_directory_uri() . '/images/white_stripe.jpg',
        'thumbnail_url' => get_stylesheet_directory_uri() . '/images/white_stripe.jpg',
        'description'   => __( 'Default Header Image', 'textdomain' )
    ),
) );

/**
 * Set up the WordPress core custom logo feature.
 *
 * @uses reddesk_header_style()
 */
 function reddesk_custom_logo_setup() {
    $defaults = array(
        'height'               => 100,
        'width'                => 300,
        'flex-height'          => true,
        'flex-width'           => true,
        'header-text'          => array( 'site-title', 'site-description' ),
        'unlink-homepage-logo' => true, 
    );
 
    add_theme_support( 'custom-logo', $defaults );
}
 

add_action( 'after_setup_theme', 'reddesk_custom_header_setup' );

if ( ! function_exists( 'reddesk_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see reddesk_custom_header_setup().
	 */
	function reddesk_header_style() {
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
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
				}
			<?php
			// If the user has set a custom color for the text use that.
		else :
			?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;
