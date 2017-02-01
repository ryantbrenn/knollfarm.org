<?php
/**
 * Press Room navigation buttons
 *
 * @author Jess Green <jgreen@periscope.com>
 * @package Cox_Automotive_Theme
 */
global $wp_query; ?>
<div class="row">
    <div class="navbar vs-xs-bottom-6">
        <?php $categories = get_categories(array('orderby' => 'id')); ?>

        <?php if (!empty($categories)) :
            $all_selected = ($wp_query->query_vars['cat'] == '') ? ' selected' : '';
            ?>
        <div class="cat-list col-lg-6 col-xs-12">
            <div class="btn-group btn-group-justified">
                <a href="<?php echo coxauto_get_pressroom_all_link(); ?>" class="btn btn-primary<?php echo $all_selected; ?>">All</a>
                <?php foreach ($categories as $category) :
                    $selected_class = ($wp_query->query_vars['cat'] == $category->term_id) ? ' selected' : '';
                    $category_link = get_category_link($category->term_id); ?>
                    <a href="<?php echo esc_url($category_link); ?>" class="btn btn-primary<?php echo $selected_class; ?>"><?php echo esc_textarea($category->name); ?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="col-lg-6 col-xs-12">
            <?php get_search_form(); ?>
        </div>
    </div>
</div>
<?php if (is_search()) : ?>
<div class="row">
    <div class="col-xs-12 vs-xs-bottom-6">
        <div class="h2 text-center">Search Results for &ldquo;<?php echo get_search_query(); ?>&rdquo;</div>
    </div>
</div>
<?php endif; ?>