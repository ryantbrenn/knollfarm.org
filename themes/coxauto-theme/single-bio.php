<?php
/**
 * Single Post template
 *
 * @package Cox_Automotive_Theme
 * @author Jess Green <jgreen@periscope.com>
 */
get_header(); ?>
<?php while (have_posts()) : the_post(); ?>
<div class="container vs-sm-top-6 vs-xs-top-4 vs-sm-bottom-6 vs-xs-bottom-4">
    <h1 class="h1 text-center vs-xs-bottom-1"><?php the_title(); ?></h1>
    <?php if (have_rows('leadership_byline')) : ?>
    <ul class="list-unstyled bio-title-list text-center vs-xs-bottom-6">
        <?php while (have_rows('leadership_byline')) : the_row(); ?>
            <li class="h2"><?php the_sub_field('leadership_byline_title');?></li>
        <?php endwhile; ?>
    </ul>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-6 text-center">
             <?php the_post_thumbnail('post-thumnail', array('class' => 'center-block img-responsive vs-xs-bottom-6')); ?>
        </div>
        <div class="col-md-6 wp-editor">
            <?php the_content(); ?>
        </div>
    </div>
</div>
<?php endwhile; ?>
<?php get_footer('with-fractal');
