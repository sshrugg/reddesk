<?php
/**
 * Red Desk Electric functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Red_Desk_Electric
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'reddesk_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function reddesk_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Red Desk Electric, use a find and replace
		 * to change 'reddesk' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'reddesk', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

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

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'reddesk' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'reddesk_custom_background_args',
				array(
					'default-color' => '8C262E',
					'default-image' => get_template_directory_uri() . '/images/background.jpg',
                                        'default-repeat' => 'no-repeat',
                                        'default-attachment' => 'fixed',
                                        'default-position-x' => 'center',
                                        'default-position-y' => 'center',
                                        'default-size'           => 'cover',
                                        'wp-head-callback'       => '_custom_background_cb',
                                        'admin-head-callback'    => '',
                                        'admin-preview-callback' => ''
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'reddesk_setup' );

/**
 * Register custom fonts.
 */
function reddesk_fonts_url() {
	$fonts_url = '';

	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Merriweather, and Titillium translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$merriweather = _x( 'on', 'Merriweather  font: on or off', 'reddesk' );
        $titillium = _x( 'on', 'Titillium font: on or off', 'reddesk' );

        $font_families = array();

	if ( 'off' !== $merriweather ) {
            $font_families[] = 'Merriweather:300,300i,400,400i,700,700i,900,900i';
        }

        if ( 'off' !== $titillium ) {
            $font_families[] = 'Titillium+Web:200,200i,400,400i,700,700i,900';
        }

        if (in_array ('on', array($merriweather,$titillium))){
            $query_args = array(
		'family' => urlencode( implode( '|', $font_families ) ),
		'subset' => urlencode( 'latin,latin-ext' ),
            );
            $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}
/**
 * Add preconnect for Google Fonts.
 *
 */
function reddesk_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'reddesk-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'reddesk_resource_hints', 10, 2 );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function reddesk_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'reddesk_content_width', 640 );
}
add_action( 'after_setup_theme', 'reddesk_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function reddesk_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'reddesk' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'reddesk' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'reddesk_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function reddesk_scripts() {
    //Enqueue Google Fonts: Merriweather, Titillium
        wp_enqueue_style( 'reddesk-fonts', reddesk_fonts_url() );
        wp_enqueue_style( 'reddesk-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'reddesk-style', 'rtl', 'replace' );

	wp_enqueue_script( 'reddesk-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
        
        if(is_home() && is_front_page()){
                wp_enqueue_script( 'reddesk-shrinkHeader', get_template_directory_uri() . '/js/shrinkHeader.js', array(), '0.1', true );
        }
        
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'reddesk_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}