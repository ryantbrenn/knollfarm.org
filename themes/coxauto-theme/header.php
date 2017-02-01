<?php
/**
 * Header template
 *
 * @author
 * @package Cox_Automotive_Theme
 * @version $Id$
 */
?>
<!DOCTYPE html>
<html>
<head>

    <?php wp_head(); ?>

    <meta name="viewport" content="width=device-width">
</head>
<body <?php body_class();?>>

    <!-- Google Tag Manager -->
    <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-MLHG5Z"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push(
    {'gtm.start': new Date().getTime(),event:'gtm.js'}
    );var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-MLHG5Z');</script>
    <!-- End Google Tag Manager -->

    <header>
        <!-- Fixed navbar -->
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo home_url('/'); ?>">
                        <img src="<?php echo get_theme_mod('larger_screen_header_image'); ?>" class="hidden-xs hidden-sm img-responsive">
                        <img src="<?php echo get_theme_mod('small_screen_header_image'); ?>" class="hidden-md hidden-lg img-responsive">
                        <span class="sr-only"><?php bloginfo('name') ?></span>
                    </a>
                </div>
                <div id="navbar" class="main-nav navbar-collapse collapse" aria-expanded="true">
                    <?php
                    wp_nav_menu(array(
                        'theme_location'  => 'header',
                        'container'       => 'div',
                        'container_class' => 'clearfix',
                        'menu_id'         => '',
                        'menu_class'      => 'nav navbar-nav navbar-right text-uppercase nav-main',
                    ));

                    wp_nav_menu(array(
                        'theme_location'  => 'header-dropdowns',
                        'container'       => 'div',
                        'menu_id'         => '',
                        'menu_class'      => 'nav navbar-nav navbar-right text-uppercase nav-dropdowns',
                        'walker'          => new MobileDropDown(),
                    ));
                    ?>
                </div>
            </div>
        </nav>
    </header>
