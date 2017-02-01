<?php
/**
 * Tinymce Typography Formats
 *
 * @package Cox_Auto_Theme
 * @author Spike Frye <sfrye@periscope.com>
 * @version $Id$
 */

namespace PeriscopeTheme\TinymceTypographyFormats;

/**
 * Add new style formats to TinyMCE dropdown
 *
 * @param array $init_array Array of TinyMCE settings
 * @return array
 */
function custom_styledropdown_insert_formats( $init_array )
{
    $style_formats = $init_array['style_formats'];
    if (empty($style_formats)) {
        $style_formats = array();
    } else {
        $style_formats = json_decode($style_formats);
    }

    $style_formats[] = array(
        'title' => 'Lead Text',
        'classes' => 'lead',
        'selector' => '*'
    );

    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $style_formats );

    return $init_array;
}
add_filter( 'tiny_mce_before_init', 'PeriscopeTheme\TinymceTypographyFormats\custom_styledropdown_insert_formats' );
