<?php
/**
 * Template Name: Contact Us
 *
 * @package Cox_Automotive_Theme
 * @author Spike Frye <sfrye@periscope.com>
 */
get_header(); ?>
<?php while(have_posts()) : the_post(); ?>
    <?php get_template_part('partials/display-modules-list'); ?>

    <div class="container vs-xs-top-6 vs-md-top-10">
        <h1 class="text-center vs-xs-bottom-6"><?php the_title() ?></h1>

        <div class="row">
            <div class="contact-form col-md-8 col-xs-12 vs-xs-bottom-6 vs-md-bottom-0">
                <?php gravity_form(1); ?>
            </div>
            <div class="col-xs-12 col-md-3 pr-sidebar">
                <?php if (have_rows('contact_us_fields')) : ?>
                    <ul class="list-unstyled pr-list">
                    <?php while (have_rows('contact_us_fields')) : the_row(); ?>
                        <li class="pr-item">
                            <h3><?php the_sub_field('contact_us_fields_title'); ?></h3>
                            <div class="wp-editor">
                                <?php echo apply_filters('the_content', get_sub_field('contact_us_fields_information'));?>
                            </div>
                        </li>
                    <?php endwhile; ?>
                    </ul>
                <?php endif; ?>
                <?php
                    //TODO move to a wrapper function
                    $page_ID = intval(get_option('page_for_posts'));
                    require locate_template(array('partials/press-room-staff.php'), false, false);
                ?>
            </div>
        </div>
    </div>
<?php endwhile; ?>

<?php get_footer('with-fractal');
