<?php
/**
 * Button display module
 *
 * @package Cox_Automotive_Theme
 * @author Jess Green <jgreen@periscope.com>
 */

if (!get_field('module_button_use_external_url')) {
    $link = get_field('module_button_internal_url');
} else {
    $link = get_field('module_button_external_url');
}

if (!get_field('module_button_open_new_window')) {
    $target = "";
} else {
    $target = " target=\"_blank\"";
}

if (!$link) return;
?>
<div <?php coxauto_display_module_class(); ?>>
    <a <?php coxauto_display_module_button_class() ?> href="<?php echo esc_url($link); ?>"<?php echo $target; ?>><?php the_field('module_button_text'); ?></a>
</div>
