<?php
/**
 * Text display module
 *
 * @package Cox_Automotive_Theme
 * @author Jess Green <jgreen@periscope.com>
 */
?>
<div <?php coxauto_display_module_class(); ?>>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-10 col-lg-8 center-block wp-editor <?php echo coxauto_get_display_module_animation_classes() ?>">
                <?php echo apply_filters('the_display_module_content', get_field('display_module_content', get_the_ID())); ?>
            </div>
        </div>
    </div>
</div>
