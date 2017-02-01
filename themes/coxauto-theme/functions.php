<?php
/**
 * Periscope WordPress Skeleton
 *
 * @author Jess Green <jgreen@periscope.com>
 * @package Cox_Automotive_Theme
 * @version $Id$
 */
namespace PeriscopeTheme;

define('THEME_TEMPLATE_URL', get_template_directory_uri() . '/');
define('THEME_TEMPLATE_PATH', get_template_directory() . '/');
define('PERSK_TEXT_DOMAIN', 'coxauto-theme');
define('THEME_CACHE_GROUP', 'coxauto-theme');

add_action('after_setup_theme', array('PeriscopeTheme\ThemeConfig', 'after_setup_theme'));

final class ThemeConfig
{


    /**
     * Instance of class
     *
     * @var \PeriscopeTheme\ThemeConfig
     */
    static protected $_instance = null;


    /**
     * Get instance of class
     *
     * @return \PeriscopeTheme\ThemeConfig
     */
    static public function get_instance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }


    /**
     * PHP5 Constructor function
     *
     * @return \PeriscopeTheme\ThemeConfig
     */
    public function __construct()
    {
        $this->includes()
             ->supports()
             ->menus();

        return $this;
    }


    /**
     * Run on after_setup_theme
     *
     * @see after_setup_theme
     *
     * @return void
     */
    static public function after_setup_theme()
    {
        self::$_instance = new self();

        // load dependencies
        ThemeDependencies::init();

        add_editor_style(array(
            'assets/styles/wysiwyg.css',
            'assets/styles/screen.css',
            '//fast.fonts.net/cssapi/97d1f769-6abc-417d-a5fb-29ff387bb744.css',
            '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css'
        ));
    }


    /**
     * Add additional PHP files
     *
     * @return \PeriscopeTheme\ThemeConfig
     */
    private function includes()
    {
        require THEME_TEMPLATE_PATH . 'lib/class-theme-dependencies.php';
        require THEME_TEMPLATE_PATH . 'lib/class-brandfilter-walker.php';
        require THEME_TEMPLATE_PATH . 'lib/class-mobile-dropdown.php';
        require THEME_TEMPLATE_PATH . 'lib/button-shortcode-api.php';
        require THEME_TEMPLATE_PATH . 'lib/theme-functions.php';
        require THEME_TEMPLATE_PATH . 'lib/display-module-functions.php';
        require THEME_TEMPLATE_PATH . 'lib/display-module-preview-functions.php';
        require THEME_TEMPLATE_PATH . 'lib/typography-tinymce-formats.php';

        return $this;
    }


    /**
     * Add theme features
     *
     * @return \PeriscopeTheme\ThemeConfig
     */
    private function supports()
    {
        // add add_theme_supports() calls here
        add_theme_support('post-thumbnails');
        add_theme_support('title-tag');

        // Supports HTML5. Remove if project requires legacy support
        add_theme_support('html5',
            array(
                'comment-list',
                'comment-form',
                'search-form',
            )
        );

        return $this;
    }


    /**
     * Add register_nav_menu() calls
     *
     * @return \PeriscopeTheme\ThemeConfig
     */
    private function menus()
    {
        register_nav_menus(array(
            'header'           => 'Main navigation menu located in header.',
            'header-dropdowns' => 'Main navigation menu located in header that contains dropdowns',
            'social-media'     => 'Social Media menu',
            'footer-links'     => 'Footer Links',
        ));

        return $this;
    }


    /**
     * Add register_sidebar calls
     * @return \PeriscopeTheme\ThemeConfig
     */
    private function sidebars()
    {
        return $this;
    }
}