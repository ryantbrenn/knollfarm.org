<?php
/**
 * Template Name: Bio List Page
 *
 * @package Cox_Automotive_Theme
 * @author Jess Green <jgreen@periscope.com>
 */
get_header(); ?>

    <?php while(have_posts()) : the_post(); ?>
        <?php get_template_part('partials/display-modules-list'); ?>
    <?php endwhile; ?>

    <?php
        /*
         * Output the leadership.
         */
        $leadership = new WP_Query(array(
            'posts_per_page' => -1,
            'post_type' => 'bio'
        ));

        if($leadership->have_posts()):
    ?>
        <div class="vs-xs-top-6">
            <div class="fractal-repeated-top"></div>

            <div class="fractal-repeated vsp-xs-bottom-6">
                <div class="container image-grid">
                    <div class="image-grid__row">
                        <?php foreach($leadership->get_posts() as $leader) : ?>
                            <div class="image-grid__item">
                                <?php $image = get_field('list_image', $leader->ID) ?>
                                <div class="image-grid__item__image" style="background-image: url('<?php echo $image['url']; ?>');"></div>

                                <div class="image-grid__item__container">
                                    <h2 class="image-grid__item__title"><?php echo $leader->post_title; ?></h2>

                                    <div class="image-grid__item__content">
                                        <?php if (have_rows('leadership_byline', get_post_field('ID', $leader))) : ?>
                                            <ul class="list-unstyled bio-title-list">
                                                <?php while (have_rows('leadership_byline', get_post_field('ID', $leader))) : the_row(); ?>
                                                    <li><?php the_sub_field('leadership_byline_title');?></li>
                                                <?php endwhile; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </div>

                                    <a href="<?php echo get_permalink($leader) ?>" class="btn btn-primary btn-block arrow-right">View Bio</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php get_footer();