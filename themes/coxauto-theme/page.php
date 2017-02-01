<?php
/**
 * @package Cox_Automotive_Theme
 * @author Spike Frye <sfrye@periscope.com>
 */
get_header(); ?>
    <?php while(have_posts()) : the_post(); ?>
        <div class="container vs-xs-top-3 vs-md-top-6">
            <h1 class="text-center"><?php the_title() ?></h1>

            <div class="wp-editor vs-xs-top-3">
                <?php the_content(); ?>
            </div>
        </div>
    <?php endwhile; ?>
<?php get_footer('with-fractal');
