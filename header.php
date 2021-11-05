<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Red_Desk_Electric
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'reddesk' ); ?></a>

	<header id="masthead" class="site-header
                <?php
                if ( is_front_page() && is_home() ) :
                    ?>
                        scrollShrink
                    <?php
                else :
                    ?>
                        smaller
                    <?php
                endif; ?>
                ">
            <div class="site-branding"
                 
                 
            <?php if ( is_front_page() && is_home() ) : ?> 
            style="background-image: url(<?php header_image() ?>); background-size: cover; background-position: bottom center; repeat: no-repeat"
            <?php endif; ?>
            >
            
                <div class="logo-container">
                <!--Logo -->
                
                
                
                <a href ="<?php get_home_url() ?>" class="custom-logo-link">
			<?php
			//the_custom_logo();
                            $custom_logo_id = get_theme_mod( 'custom_logo' );
                            $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );

                            if ( has_custom_logo() ) {
                                echo '<img src="' . esc_url( $logo[0] ) . '" alt="' . get_bloginfo( 'name' ) . '" class="custom-logo" >';
                            } else {
                                echo '<h1>' . get_bloginfo('name') . '</h1>';
                            }
                        ?>
                </a>
                
                
                
                </div><!-- .logo-container -->
            
                
            <!-- Site Branding Text-->
                <div class="site-branding-text">
                            <div class="site-branding-text-container">
                                <?php
                                if ( is_front_page() && is_home() ) :
                                        ?>
                                        <h1 class="site-title scrollShrink"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                                        <?php
                                else :
                                        ?>
                                        <p class="site-title smaller"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                                        <?php
                                endif; ?>
                            </div><!-- .site-title-container -->
                            
                            
                            <div class="site-branding-text-container">
                                <?php
                                $reddesk_description = get_bloginfo( 'description', 'display' );
                                if ( $reddesk_description || is_customize_preview() ) :
                                        ?>
                                        <p class="site-description
                                            <?php
                                                if ( is_front_page() && is_home() ) :
                                                    ?>
                                                        scrollShrink
                                                    <?php
                                                else :
                                                    ?>
                                                        smaller
                                                    <?php
                                                endif; ?>
                                           "><?php echo $reddesk_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
                                <?php endif; ?>
                            </div><!-- .site-description-container -->
                                    
                                    
                </div><!-- .site-branding-text -->
                                
            </div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'reddesk' ); ?></button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				)
			);
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->
<div id="header-spacer" class="header-spacer <?php if ( is_front_page() && is_home() ) :?>scrollShrink<?php else :?>smaller<?php endif; ?>"></div>