<?php
/**
 * Default template (see {@link http://codex.wordpress.org/images/1/18/Template_Hierarchy.png Template Hierarchy})
 *
 * @author
 * @package Cox_Automotive_Theme
 * @version $Id$
 */

if (is_search()) {
    // WordPress doesn't use search.php when no results are found. It defaults to index.php
    locate_template('home.php', true);
} else {
    get_header(); ?>

    <div class="hfeed">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <div <?php post_class(); ?>>
                <h2><?php the_title(); ?></h2>

                <div class="wp-editor">
                    <?php the_content(); ?>
                </div>
            </div>

        <?php endwhile; endif; ?>
    </div>

    <?php get_sidebar(); ?>

    <?php get_footer('with-fractal');
}