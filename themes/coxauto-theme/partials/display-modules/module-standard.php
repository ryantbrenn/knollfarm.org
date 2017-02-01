<?php
/**
 * Standard display module
 *
 * @package Cox_Automotive_Theme
 * @author Jess Green <jgreen@periscope.com>
 */
?>
<div <?php coxauto_display_module_class(); ?>>
    <h3 class="headline"><?php the_field('display_module_headline'); ?></h3>
    <div class="image">
        <?php the_post_thumbnail(); ?>
    </div>
    <div class="wp-editor">
        <?php echo apply_filters('the_display_module_content', get_field('display_module_content', get_the_ID())); ?>
    </div>
</div>
