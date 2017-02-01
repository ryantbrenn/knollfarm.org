<?php
/**
 * Display Module controller template
 *
 * @package Cox_Automotive_Theme
 * @author Jess Green <jgreen@periscope.com>
 */
global $post;
$display_module_type = get_field('display_module_type', get_the_ID());

$list_item_modifier = '';

$height_mode = get_field('display_module_height_mode');

if ($height_mode == 'full-screen'):
    $list_item_modifier = '--full-height';
endif;

$remove_spacing_modifier = '';
if (get_field('display_module_remove_vertical_spacing')) :
    $remove_spacing_modifier = ' no-space';
endif;

$display_module_id = get_field('display_module_id') ? get_field('display_module_id') : 'display-module-' . get_the_ID();
?>
<div id="<?php esc_attr_e($display_module_id); ?>" class="display-module-list__item<?php echo $list_item_modifier ?><?php echo $remove_spacing_modifier;?>">
    <?php get_template_part('partials/display-modules/module', $display_module_type) ?>
</div>
