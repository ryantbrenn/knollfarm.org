<?php
/**
 * Display Module navigation
 * @author Jess Green <jgreen@periscope.com>
 * @package Cox_Automotive_Theme
 */
$cols = get_field('display_module_navigation');
$columns = coxauto_get_columns($cols);

$number_of_nav_link_lines = intval(get_field('display_module_navigation_lines_of_navigation_link_text'));
$additional_classes = array();

if ($number_of_nav_link_lines > 1) {
    $additional_classes[] = 'display-module-nav--' . $number_of_nav_link_lines . '-line-btns';
}
?>
<div <?php coxauto_display_module_class('', $additional_classes); ?>>
    <?php coxauto_display_module_embedded_style(); ?>
    <div class="container hidden-sm hidden-xs">
        <?php if (have_rows('display_module_navigation')) : ?>
            <div class="row">
                <?php
                    $c = 0;
                    while(have_rows('display_module_navigation')) : the_row();
                        $c++;
                        $offset = (($columns == 2 && count($cols) == 5) && $c == 1) ? 'col-md-offset-1 ' : '';
                        $display_module_ID = get_sub_field('display_module_to_link_to'); ?>

                        <div class="<?php echo $offset; ?>col-md-<?php echo $columns; ?> text-center vsp-xs-top-5 vsp-xs-bottom-5 <?php echo coxauto_get_display_module_animation_classes() ?>">
                            <div class="wp-editor">
                                <?php the_sub_field('display_module_navigation_content'); ?>
                            </div>

                            <?php if (get_sub_field('display_module_navigation_link_text')) :
                                    $display_module_slug = get_field('display_module_id', $display_module_ID) ? get_field('display_module_id', $display_module_ID) : 'display-module-' . intval($display_module_ID);
                                    ?>
                                <a href="#<?php esc_attr_e($display_module_slug) ?>" class="display-module-nav__btn">
                                    <span class="display-module-nav__btn__body"><?php the_sub_field('display_module_navigation_link_text'); ?></span>
                            </a>
                            <?php endif; ?>
                        </div>

                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
