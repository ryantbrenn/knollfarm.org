<?php
/**
 * Video module
 *
 * @package Cox_Automotive_Theme
 * @author Jess Green <jgreen@periscope.com>
 */

/**
 * The global declaration enables autocomplete in PhpStorm and Netbeans
 * @global $wp_embed \WP_Embed
 */
global $wp_embed;

$sub_head = esc_textarea(get_field('display_module_sub_head'));
$video = esc_url(get_field('display_module_video_url')) . "&rel=0";

?>
<div <?php coxauto_display_module_class(); ?>>
        <div class="container">
            <div class="row">
                <div class="col-md-10 center-block">
                    <div class="video-container embed-responsive embed-responsive-16by9">
                        <?php echo $wp_embed->autoembed($video); ?>
                    </div>
                </div>
            </div>
        </div>
</div>