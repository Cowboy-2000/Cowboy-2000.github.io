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
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'books' ); ?></a>

	<header id="masthead" class="site-header">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container site-header__container">
                <div class="row site-header__row">
                    <div class="col-lg-12 site-header__col">
                        <div class="site-header__logo logo">
                            <a href="<?php bloginfo('url'); ?>" class="navbar-brand logo__navbar-brand">
                            <?php bloginfo('name'); ?></a>
                        </div><!-- .logo__navbar-brand -->
                        <button class="navbar-toggler navbar__navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <?php
                            wp_nav_menu(
                                array(
                                    'menu_id'         => 'primary-menu',
                                    'container_class' => 'collapse navbar-collapse navbar__collapse',
                                    'menu_class'      => 'navbar__list navbar-nav ms-auto mb-2 mb-lg-0',
                                    'container_id'    => 'navbarSupportedContent',
                                    'theme_location'  => 'menu-1',
                                )
                            );
                        ?>
                    </div><!-- .site-header__col -->
                </div><!-- .row -->
            </div><!-- .container -->
        </nav>
	</header><!-- #masthead -->