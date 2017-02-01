<?php
/**
 * Periscope WordPress Skeleton
 *
 * @author Jess Green <jgreen@periscope.com>
 * @package Cox_Automotive_Theme
 * @version $Id$
 */
namespace PeriscopeTheme;
/**
 * Dependencies
 *
 * @todo Add getters/setters for Script/Style enqueues
 * @todo Add support for wp_localize_script
 *
 * @subpackage Dependencies
 * @author Jess Green <jgreen@psy-dreamer.com>
 */
class ThemeDependencies
{


    /**
     * Setup array of styles for registering/enqueueing
     * Format:
     * [handle]
     * OR
     * [handle] => [
     *      src   => script url. relative to theme or absolute URL (required),
     *      ver   => script ver (optional)
     *      dep   => stylesheet dependencies (optional)
     *      media => stylesheet media. Sets media attribute on <link>. Defaults to all (can be media queries, etc.)
     * ]
     * 
     * If the dependencies property is populated but there are no styles/scripts matching that handle then
     * the stylesheet will not be loaded.
     * 
     * @var array
     */
    protected $styles = array(
        'font-awesome' => array(
            'src'   => '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css',
            'dep'   => array(),
            'media' => 'all',
        ),

        'screen' => array(
            'src' => 'assets/styles/screen-blessed.css',
            'dep' => array('font-awesome'),
            'media' => 'screen',
        ),

        'wysiwyg' => array(
            'src' => 'assets/styles/wysiwyg.css',
            'dep' => array('font-awesome', 'screen'),
            'media' => 'screen',
        ),

        'webfonts' => array(
            'src' => '//fast.fonts.net/cssapi/97d1f769-6abc-417d-a5fb-29ff387bb744.css',
            'dep' => array(),
            'media' => 'all',
        ),

        'animate' => array(
            'src' => 'assets/styles/animate.css',
            'dep' => array(),
            'media' => 'all',
        ),
    );


    /**
     * Array of styles for registering/enqueueing concatenated/minified
     * stylesheets
     *
     * @see ThemeDependencies::$styles for parameters
     * @var array
     */
    protected $styles_concat = array(
        /**
         * Also include any external stylesheets, like Google Webfonts or Myfonts.com
         */
        'screen' => array(
            'src'   => 'assets/styles/screen.min.css',
            'dep'   => array(),
            'media' => 'screen',
        ),
    );


    /**
     * Setup array of styles for registering/enqueueing
     * Format:
     * [handle]
     * OR
     * [handle] => [
     *      src       => script url. relative to theme or absolute url. (required),
     *      ver       => script ver (optional)
     *      dep       => stylesheet dependencies (optional)
     *      in_footer => whether or not to load in footer. Defaults to true.
     * ]
     *
     * @var array
     */
    protected $scripts = array(
        'bootstrap' => array(
            'src' => 'assets/scripts/bootstrap-3.3.6.js',
            'dep' => array('jquery'),
            'in_footer' => false,
        ),
        'theme-global' => array(
            'src' => 'assets/scripts/global.js',
            'dep' => array('jquery', 'bootstrap'),
            'in_footer' => false,
        ),
        'vide' => array(
            'src' => 'assets/scripts/vendor/jquery.vide.min.js',
            'dep' => array('jquery'),
            'in_footer' => false,
        ),
        'wow' => array(
            'src' => 'assets/scripts/vendor/wow.min.js',
            'dep' => array('jquery'),
            'in_footer' => false,
        )
    );

    
    /**
     * Setup array of scripts for registering/enqueueing
     * 
     * @see ThemeDependencies::$scripts for parameters
     * @var array
     */
    protected $scripts_concat = array(
        'theme-global' => array(
            'src' => 'assets/scripts/global.min.js',
            'dep' => array('jquery'),
            'in_footer' => false,
        ),
    );


    /**
     * Instance of object
     *
     * @var \Dependencies
     */
    protected static $_instance = null;


    /**
     * Theme data
     *
     * @var WP_Theme
     */
    protected $theme_data;


    /**
     * Init object
     * @return void
     */
    public static function init()
    {
        self::$_instance = new self();
    }


    /**
     * PHP5 Constructor. Init object
     *
     * @return void
     */
    protected function __construct()
    {
        $this->theme_data = wp_get_theme();

        add_action('wp_enqueue_scripts', array($this, 'register_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'register_styles'));
    }


    /**
     * Register scripts
     *
     * @return void
     */
    public function register_scripts()
    {
        $defaults = $this->get_defaults();
        
        $scripts  = $this->get_minified('scripts');
        foreach ($scripts as $handle => $script_data) {

            // if script data is empty, the script is already registered,
            // ie: a WordPress core JS script
            if (empty($script_data)) {
                continue;
            }
            

            // if src isn't set, skip
            if (!isset($script_data['src'])) {
                continue;
            }
            
            extract(wp_parse_args($script_data, $defaults), EXTR_OVERWRITE);

            // check if $src is relative or absolute URL
            $src = $this->url_relative($src);
            wp_register_script($handle, $src, $dep, $ver, $in_footer);
        }

        $this->enqueue_dependencies();
    }


    /**
     * Register styles
     *
     * @return void
     */
    public function register_styles()
    {
        $defaults = $this->get_defaults('styles');
        $styles   = $this->get_minified('styles');
        foreach ($styles as $handle => $script_data) {

            // if script data is empty, the script is already registered,
            // ie: a WordPress core CSS file
            if (empty($script_data)) {
                continue;
            }

            // if src isn't set, skip
            if (!isset($script_data['src'])) {
                continue;
            }

            extract(wp_parse_args($script_data, $defaults), EXTR_OVERWRITE);

            // check if $src is relative or absolute URL
            $src = $this->url_relative($src);
            wp_register_style($handle, $src, $dep, $ver, $media);
        }

        $this->enqueue_dependencies('styles');
    }
    
    
    /**
     * Get minified styles or scripts array. If one of the minification
     * constants is enabled, return the _concat property for each. If not,
     * return the normal property
     * 
     * @param string $type Type to load. scripts or styles
     * @return string
     */
    private function get_minified($type = 'scripts')
    {
        if ((defined('PERSK_USE_MINIFIED_ALL') && PERSK_USE_MINIFIED_ALL)
            || (defined('PERSK_USE_MINIFIED_CSS') && PERSK_USE_MINIFIED_CSS && $type == 'styles')
                || (defined('PERSK_USE_MINIFIED_JS') && PERSK_USE_MINIFIED_JS && $type == 'scripts')) {
            
            return $this->{"{$type}_concat"};
        }
        
        return $this->{$type};
    }
    
    

    /**
     * Enqueue registered scripts or styles
     *
     * @param string $type Script or Stylesheet (scripts|styles)
     * @return void|boolean
     */
    private function enqueue_dependencies($type = 'scripts')
    {
        if (!in_array($type, array('scripts', 'styles'))) {
            return false;
        }

        $deps = $this->get_minified($type);
        foreach ($deps as $handle => $script_data) {
            if ($type == 'scripts') {
                wp_enqueue_script($handle);
            } else {
                wp_enqueue_style($handle);
            }
        }
    }


    /**
     * Get defaults array for scripts or styles
     *
     * @param string $type Get defaults for which? scripts or styles
     *
     * @return array
     */
    private function get_defaults($type = 'scripts')
    {
        $defaults = array(
            'src' => '',
            'dep' => array(),
            'ver' => $this->theme_data->version,
        );

        if ($type == 'scripts') {
            $defaults['in_footer'] = true;
        } else {
            $defaults['media'] = 'all';
        }

        return $defaults;
    }


    /**
     * Checks if URL is relative
     *
     * @param string $url Url to test
     * @return boolean
     */
    private function url_relative($url)
    {
        if (strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0 && strpos($url, '//') !== 0) {
            $url = trailingslashit(get_template_directory_uri()) . $url;
        }

        return $url;
    }
}