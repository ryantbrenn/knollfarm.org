<?php
/**
 * Button short-code "API"
 *
 * @package Arctic_Cat_Theme
 * @author Jess Green <jgreen@periscope.com>
 * @version $Id$
 */
namespace PeriscopeTheme\ButtonShortcode;

/**
 * Button short-code handler
 *
 * @param array $atts Attributes array
 * @return string
 */
function button_shortcode_handler($atts)
{
    wp_kses_allowed_html();
    $attrs = shortcode_atts(array(
        'link'    => '#',
        'text'    => __('Click Here', PERSK_TEXT_DOMAIN),
        'attrib'  => '',
        'class'   => 'btn btn-primary',
        'wrapper' => '',
    ), $atts);

    // create attribute string from array
    $attributes = 'title="' . esc_attr($attrs['text']) . '"' . (!empty($attrs['attrib']) ? ' '. $attrs['attrib'] : '');

    $open_tag  = '';
    $close_tag = '';
    if (!empty($attrs['wrapper'])) {
        $open_tag  = "<{$attrs['wrapper']}>";
        $close_tag = "</{$attrs['wrapper']}>";
    }

    $btn_markup = $open_tag . '<a href="%1$s" class="%3$s" %4$s >%2$s</a>' . $close_tag;
    $button     = vsprintf($btn_markup, array(esc_url($attrs['link']), $attrs['text'], $attrs['class'], $attributes));

    return $button;
}
add_shortcode('button', 'PeriscopeTheme\ButtonShortcode\button_shortcode_handler');


/**
 * Add a custom style dropdown to the WP editor
 *
 * @param array $buttons Array of existing buttons
 * @return array
 */
function custom_styledropdown_buttons_2( $buttons )
{
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
add_filter('mce_buttons_2', 'PeriscopeTheme\ButtonShortcode\custom_styledropdown_buttons_2');


/**
 * Add new style formats to TinyMCE dropdown
 *
 * @param array $init_array Array of TinyMCE settings
 * @return array
 */
function custom_styledropdown_insert_formats( $init_array )
{

    // Define the style_formats array
    // Define the style_formats array
    $style_formats = array(
        // Each array child is a format with it's own settings
        array(
            'title' => 'Button CTA Dark Blue',
            'selector' => 'a',
            'classes' => 'btn btn-primary fa',
        ),
        array(
            'title' => 'Button CTA White',
            'selector' => 'a',
            'classes' => 'btn btn-default fa',
        ),
        array(
            'title' => 'Arrow Right',
            'selector' => 'a',
            'classes' => 'fa arrow-right',
        ),
        array(
            'title' => 'Arrow Down',
            'selector' => 'a',
            'classes' => 'fa arrow-down',
        ),

    );

    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $style_formats );

    return $init_array;

}
add_filter( 'tiny_mce_before_init', 'PeriscopeTheme\ButtonShortcode\custom_styledropdown_insert_formats' );