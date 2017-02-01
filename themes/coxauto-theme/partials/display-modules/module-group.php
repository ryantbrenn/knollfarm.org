<?php
/**
 * Group Display module
 *
 * @package Cox_Automotive_Theme
 * @author Jess Green <jgreen@periscope.com>
 */
?>
<div <?php coxauto_display_module_class(); ?>>
    <?php coxauto_display_module_embedded_style(false, false, false, 'image-ratio'); ?>
    <div class="group__body">
        <?php get_template_part('partials/display-modules-list'); ?>
    </div>
</div>
