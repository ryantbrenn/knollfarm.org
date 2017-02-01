<?php
/**
 * Module Grid
 *
 * @package Cox_Automotive_Theme
 * @author Jess Green <jgreen@periscope.com>
 */
$callout_image = get_field('module_grid_callout_image');
$callout_image_position = get_field('module_grid_callout_image_position');
$text_is_left_of_image = $callout_image_position == 'right';
?>

<div <?php coxauto_display_module_class(); ?>>
    <div class="container">
        <div class="row row--inline-grid">
            <div class="col-xs-12 col-md-6 <?php if($text_is_left_of_image): ?>col-md-pull-6<?php endif; ?>">
                <img src="<?php echo esc_url($callout_image['url']); ?>" alt="" class="img-responsive <?php echo coxauto_get_display_module_animation_classes() ?>" />
            </div>

            <div class="col-xs-12 col-md-6 <?php if($text_is_left_of_image): ?>col-md-push-6<?php endif; ?>  <?php echo coxauto_get_display_module_animation_classes() ?> vs-xs-top-3 vs-md-top-0">
                <div class="wp-editor ">
                    <?php echo apply_filters('the_display_module_content', get_field('display_module_content')); ?>
                </div>
            </div>
        </div>
    </div>
</div>
