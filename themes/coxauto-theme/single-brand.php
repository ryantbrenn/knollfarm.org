<?php
/**
 * @package Cox_Automotive_Theme
 * @author Spike Frye <sfrye@periscope.com>
 */
get_header(); ?>

<?php while(have_posts()) : the_post(); ?>
    <?php get_template_part('partials/display-modules-list'); ?>
<?php endwhile; ?>

<?php get_footer('with-fractal');
