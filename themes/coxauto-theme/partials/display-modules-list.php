<?php
/**
 * Display Modules template
 *
 * @package Cox_Automotive_Theme
 * @author Jess Green <jgreen@periscope.com>
 */

$display_modules = get_field('page_display_modules');

if (!empty($display_modules)) :
    foreach ($display_modules as $post) {
        setup_postdata($post);
        get_template_part('partials/display-module');
    }

    wp_reset_postdata();
endif;