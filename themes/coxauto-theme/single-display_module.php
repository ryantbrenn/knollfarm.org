<?php
/**
 * Single Display Module preview template
 *
 * @package Cox_Automotive_Theme
 * @author Jess Green <jgreen@periscope.com>
 */
get_header(); ?>
<?php while(have_posts()) : the_post(); ?>
    <div <?php post_class('vs-xs-top-10'); ?>>
        <?php get_template_part('partials/display-module'); ?>
    </div>
<?php endwhile; ?>
<?php get_footer('with-fractal');
