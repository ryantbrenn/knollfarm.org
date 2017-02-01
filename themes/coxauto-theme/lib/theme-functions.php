<?php
/**
 * Periscope WordPress Skeleton
 *
 * @author Jess Green <jgreen@periscope.com>
 * @package Cox_Automotive_Theme
 * @version $Id$
 */

add_action( 'customize_register', function ( $wp_customize ) {
    $wp_customize->add_setting( 'small_screen_header_image' , array(
        'default'     => null,
        'transport'   => 'refresh',
    ));

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'small_screen_header_image', array(
        'label'        => __( 'Small Screen Header Image', 'coxauto-theme'),
        'section'    => 'title_tagline',
        'settings'   => 'small_screen_header_image',
        'priority' => 10,
    )));


    $wp_customize->add_setting( 'larger_screen_header_image' , array(
        'default'     => null,
        'transport'   => 'refresh',
    ));

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'larger_screen_header_image', array(
        'label'        => __( 'Larger Screen Header Image', 'coxauto-theme'),
        'section'    => 'title_tagline',
        'settings'   => 'larger_screen_header_image',
        'priority' => 10,
    )));


    $wp_customize->add_section( 'footer' , array(
        'title'      => __( 'Footer', 'coxauto-theme'),
        'priority'   => 200,
    ) );


    $wp_customize->add_setting( 'footer_image' , array(
        'default'     => null,
        'transport'   => 'refresh',
    ));

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'footer_image', array(
        'label'        => __( 'Image', 'coxauto-theme'),
        'section'    => 'footer',
        'settings'   => 'footer_image',
        'priority' => 10,
    )));


    $wp_customize->add_setting( 'footer_contact_address' , array(
        'default'     => null,
        'transport'   => 'refresh',
    ));

    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'footer_contact_address', array(
        'label'         => __( 'Contact Address', 'coxauto-theme'),
        'section'       => 'footer',
        'settings'      => 'footer_contact_address',
        'priority'      => 10,
        'type'          => 'textarea',
    )));

    $wp_customize->add_setting( 'footer_contact_email' , array(
        'default'     => null,
        'transport'   => 'refresh',
    ));

    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'footer_contact_email', array(
        'label'         => __( 'Email Contact', 'coxauto-theme'),
        'section'       => 'footer',
        'settings'      => 'footer_contact_email',
        'priority'      => 10,
    )));

    $wp_customize->add_setting( 'footer_copyright' , array(
        'default'     => null,
        'transport'   => 'refresh',
    ));

    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'footer_copyright', array(
        'label'         => __( 'Copyright', 'coxauto-theme'),
        'section'       => 'footer',
        'settings'      => 'footer_copyright',
        'priority'      => 10,
    )));
});


/**
 * Change excerpt_more from [...] to ...
 *
 * @param string $more
 * @return string
 */
function coxauto_excerpt_more($more)
{
    global $post;

    $permalink = get_permalink(get_post_field('ID', $post));

    return "&nbsp;<span class=\"ellipses\">&hellip;</span>&nbsp;<a href=\"{$permalink}\" class=\"readmore\">Read More</a>";
}
add_filter('excerpt_more', 'coxauto_excerpt_more');


/**
 * Add additional classes to body
 *
 * @global WP_Post $post
 * @param array $classes Array of body classes
 * @return array
 */
add_filter('body_class', function($classes)
{
    global $post;

    // Assign an environment-specific class
    if (getenv('WORDPRESS_ENV') !== '' && getenv('WORDPRESS_ENV') !== 'production') {
        $classes[] = "env-" . getenv('WORDPRESS_ENV');
    }

    // Add post-type specific body class for custom post-types
    // Consists of {$post_type}-{$post_name}. Only do this for CPTs
    if (!in_array(get_post_type(), array('post', 'page')) && !is_null($post)) {
        $classes[] = "{$post->post_type}-{$post->post_name}";
    }

    // Add a class for mobile devices
    if (wp_is_mobile()) {
        $classes[] = 'is-mobile';
    }

    return $classes;
});


/**
 * Get columns based on items in an array. Useful for laying out grids.
 *
 * @param array $array_to_count
 * @return int
 */
function coxauto_get_columns($array_to_count)
{
    $grid_count = count($array_to_count);
    $columns    = intval(floor(12 / $grid_count));

    return $columns;
}



/**
 * Get the attachement root url
 *
 * @param int $attachment_id
 * @return string
 */
function coxauto_get_assets_root_url($attachment_id)
{
    return trailingslashit(dirname(wp_get_attachment_url($attachment_id)));
}


/**
 * Get the "All" link for the Press Room navigation
 *
 * @return string
 */
function coxauto_get_pressroom_all_link()
{
    // line 561 in wp-includes/category-template.php
    $posts_page = ('page' == get_option( 'show_on_front' ) && get_option( 'page_for_posts' ))
                    ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/' );

    return esc_url($posts_page);
}


/**
 * Get an excerpt formatted for email sharing.
 * @uses coxauto_get_excerpt_without_readmore()
 * @return string
 */
function coxauto_get_excerpt_for_email()
{
    global $post;

    $permalink = get_permalink(get_post_field('ID', $post));

    $excerpt = coxauto_get_excerpt_without_readmore();
    $excerpt .= "\r\n\r\n" . "Read More: " . $permalink;

    return $excerpt;
}


/**
 * Get an unformatted excerpt that doesn't contain a read-more link
 * @return string
 */
function coxauto_get_excerpt_without_readmore()
{
    remove_filter('excerpt_more', 'coxauto_excerpt_more');
    $excerpt = str_replace('[&hellip;]', '...', get_the_excerpt());
    add_filter('excerpt_more', 'coxauto_excerpt_more');

    return $excerpt;
}


/**
 * Returns the current url.
 * Why is this not a thing in WP core?
 *
 * @return string
 */
function coxauto_get_current_url()
{
    /**
     * @global \WP $wp WordPress object
     */
    global $wp;

    $query_string = '';
    if (is_search()) { // include query_string
        $query_string = "?{$wp->query_string}";
    }

    return home_url( $wp->request . $query_string );
}


/**
 * Filter subhead content
 *
 * @param string $content
 * @return string
 */
function coxauto_filter_subhead($content)
{
    global $post;

    if ($content) {
        return strip_tags($content);
    }

    $content_bits = explode("\n", get_post_field('post_content', $post));
    if (empty($content_bits[0])) {
        return $content;
    }

    return apply_filters('the_content', $content_bits[0]);
}
add_filter('coxauto_subhead', 'coxauto_filter_subhead');


/**
 * Modify the output of the items for the Social Menu
 *
 * @param string $item_output
 * @param \WP_Post $item
 * @param int $depth
 * @param object $args
 * @return string
 */
function coxauto_modify_socialmenu_markup($item_output, $item, $depth, $args)
{
    if ($args->menu->slug !== 'social-links') {
        return $item_output;
    }


    $atts = array();
    $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
    $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
    $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
    $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

    /* Documented in  */
    $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

    $attributes = '';
    foreach ( $atts as $attr => $value ) {
        if ( ! empty( $value ) ) {
            $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
            $attributes .= ' ' . $attr . '="' . $value . '"';
        }
    }

    $social_link_class = sanitize_title_with_dashes($atts['title']);
    $icon = "<i class=\"fa fa-{$social_link_class}\"></i>";

    $item_output = "<a {$attributes}>"
        . "<span class=\"label sr-only\">" . apply_filters('the_title', $item->title) . "</span>"
        . $icon
        . "</a>";

    return $item_output;
}
add_filter('walker_nav_menu_start_el', 'coxauto_modify_socialmenu_markup', 11, 4);


/**
 * Get multiple featured images for post
 *
 * @param int $post_id
 * @param string $size
 * @return array
 */
function coxauto_get_featured_images($post_id, $size = 'post-thumbnail')
{
    $image_ids = get_field('featured_images', $post_id);
    if (!$image_ids) {
        // no images, extract from legacy fields
        $image_ids = get_post_meta_like($post_id, 'kd_featured-image');
    }

    $images = array();

    // throw the main featured image in as the first image
    $image_html = wp_get_attachment_image(get_post_thumbnail_id($post_id), $size);
    if ($image_html) {
        $images[] = $image_html;
    }

    foreach ($image_ids as $image_id) {
        $images[] = wp_get_attachment_image($image_id, $size);
    }

    return $images;
}


/**
 * Convert staging links in content to local links
 *
 * @param string $content
 * @return mixed
 */
function coxauto_convert_staging_links($content)
{
    if (strpos($content, 'coxautoinc.periscopestaging.com') === false) {
        return $content;
    }

    // filter protocols first
    $content = str_replace(array('http:', 'https:'), '', $content);
    $content = str_replace('coxautoinc.periscopestaging.com', $_SERVER['HTTP_HOST'], $content);

    return $content;
}
add_filter('the_display_module_content', 'coxauto_convert_staging_links');
add_filter('the_content', 'coxauto_convert_staging_links');


/**
 * Superscript all the things
 *
 * @param string $content
 * @return string
 */
function coxauto_rball_superscript($content)
{
    if (strpos($content, '®') !== false) {
        $content = str_replace(
            '®',
            '<sup>&reg;</sup>',
            $content
        );
    }

    return $content;
}
add_filter('the_content', 'coxauto_rball_superscript');