<?php
/**
 * Fact Display Module
 * @package Cox_Automotive_Theme
 * @author Jess Green <jgreen@periscope.com>
 */
?>

<?php if (have_rows('display_module_fact_grid')) : ?>
    <div <?php coxauto_display_module_class(); ?>>
        <div class="fact-list">
        <?php while(have_rows('display_module_fact_grid')) :  the_row(); ?>
            <div class="fact-list__container">
                <div class="fact-list__body">
                    <div class="fact-list__row">
                    <?php
                    $cells = get_sub_field('fact_grid_row');
                    $total_columns = coxauto_get_columns($cells);
                    foreach($cells as $cell) : ?>
                        <div class="fact">
                            <div class="fact-list__content">
                                <?php $img = esc_url($cell['fact_grid_cell_image']); ?>
                                <div class=" fact__title<?php echo !empty($img) ? '--w-icon ' : ' '; echo coxauto_get_display_module_animation_classes(); ?>">
                                    <?php if ($img): ?>
                                    <div class="fact__title--w-icon__icon <?php echo coxauto_get_display_module_animation_classes() ?>">
                                        <img src="<?php echo $img; ?>" alt="">
                                    </div>
                                    <div class="fact__title--w-icon__title <?php echo coxauto_get_display_module_animation_classes() ?>">
                                        <?php echo apply_filters('the_title', $cell['fact_grid_headline']); ?>
                                    </div>
                                    <?php
                                        else:
                                            echo apply_filters('the_title', $cell['fact_grid_headline']);
                                        endif;
                                    ?>
                                </div>
                                <div class="fact__body <?php echo coxauto_get_display_module_animation_classes() ?>">
                                    <?php echo apply_filters('the_content', $cell['fact_grid_supporting_copy']); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        </div>
    </div>
<?php endif; ?>
