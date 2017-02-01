<?php
/**
* Template Name: Brand List
*
* @package Cox_Automotive_Theme
* @author Spike Frye <sfrye@periscope.com>
*/
get_header(); ?>

<?php while(have_posts()) : the_post(); ?>
    <?php get_template_part('partials/display-modules-list'); ?>
<?php endwhile; ?>

<?php
/*
 * Output the leadership.
 */
$brands = new WP_Query(array(
    'orderby' => 'title',
    'order' => 'ASC',
    'posts_per_page' => -1,
    'post_type' => 'brand'
));

if($brands->have_posts()):
    ?>
    <div class="vs-xs-top-6" id="brands">
        <div class="fractal-repeated-top"></div>

        <div class="fractal-repeated vsp-xs-bottom-6">
            <div class="container image-grid">

                <div class="cat-list brand-filter-nav">
                    <ul id="js-brand-filter-list" class="list-unstyled btn-group btn-group-justified btn-group--light">
                        <li><a href="#" class="btn btn-primary btn-all btn-contents selected" data-filter="*">All</a></li>
                        <?php wp_list_categories(array(
                            'show_option_all' => false,
                            'hide_empty'      => false,
                            'depth'           => 2,
                            'title_li'        => '',
                            'taxonomy'        => 'brand_type',
                            'walker'          => new BrandFilter_Walker(),
                        )); ?>
                    </ul>
                </div>

                <div class="image-grid__row vs-xs-top-6">
                    <?php foreach($brands->get_posts() as $brand) :
                        $brand_types = wp_get_post_terms($brand->ID, 'brand_type');

                        $brand_types = array_map(function($brand_type) {
                            return '"' . $brand_type->slug . '"';
                        }, $brand_types);
                    ?>
                        <div class="image-grid__item filterable" data-filtered-by='[<?php echo implode(', ', $brand_types) ?>]'>
                            <?php $image_url = wp_get_attachment_url(get_post_thumbnail_id($brand->ID));?>
                            <div class="image-grid__item__image" style="background-image: url('<?php echo $image_url; ?>');"></div>

                            <div class="image-grid__item__container">
                                <p class="image-grid__item__content--3-lines">
                                    <?php echo $brand->brand_short_description; ?>
                                </p>

                                <a href="<?php echo get_permalink($brand) ?>" class="btn btn-primary btn-block arrow-right">Learn More</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php get_footer();
