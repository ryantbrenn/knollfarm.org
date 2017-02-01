<?php
/**
 * Press Room Page template
 * In WordPress admin, go to Settings | Reading Settings and assign the "Press Room" page to Posts under
 * "Static Page" option
 *
 * @author Jess Green <jgreen@periscope.com>
 * @package Cox_Automotive_Theme
 * @version $Id$
 */
$current_page = esc_attr( intval( (get_query_var('paged') == 0) ? 1 : get_query_var('paged') ) );
get_header(); ?>

<div class="container">
    <div class="row press-room">

        <div class="col-xs-12">
            <div class="vs-xs-top-10 vs-xs-bottom-6">
                <h1>Press Room</h1>
            </div>
        </div>

        <div class="col-xs-12 col-md-8">
            <?php get_template_part('partials/press-room', 'nav'); ?>

            <?php if (have_posts()) : ?>

                <div class="hfeed" id="js-loadmore-container">
                    <div class="paged" id="js-page-<?php echo $current_page; ?>" data-page="<?php echo $current_page; ?>">

                    <?php while (have_posts()) : the_post(); ?>

                        <article <?php post_class('vs-xs-bottom-3 vsp-xs-bottom-3 vs-lg-bottom-6 vsp-lg-bottom-6'); ?>>
                            <h3 class="meta">
                                <time><?php the_time('F j, Y'); ?></time>
                            </h3>
                            <h2 class="entry-title vs-xs-bottom-3"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <div class="entry-summary">
                                <?php the_excerpt(); ?>
                            </div>
                        </article>

                    <?php endwhile; ?>
                    </div>
                </div>
                <div id="js-loadmore-status" class="loadmore vs-xs-bottom-3">
                    <img src="<?php echo THEME_TEMPLATE_URL; ?>assets/images/loadmore.gif" alt="" />
                </div>
                <div id="js-loadmore-msg" class="loadmore vs-xs-bottom-3 error"></div>
                <p>
                    <?php
                    // because paged always == 0 instead of 1 :\
                    $next_page = (get_query_var('paged') == 0 ) ? 2 : get_query_var('paged') + 1;
                    if ($wp_query->max_num_pages >= $next_page) : ?>
                        <a data-max-pages="<?php esc_attr_e($wp_query->max_num_pages); ?>" data-next-page="<?php esc_attr_e($next_page); ?>" data-baseurl="<?php echo coxauto_get_current_url();?>" href="<?php next_posts($wp_query->max_num_pages); ?>" class="btn btn-primary btn-loadmore" id="js-btn-loadmore">Load More</a>
                    <?php endif; ?>
                </p>
            <?php else : // no results ?>
                <div class="hfeed no-results">
                    <article class="hentry">
                        <h2 class="text-center">No Results Found</h2>
                    </article>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-offset-1 col-xs-12 col-md-3 pr-sidebar">
            <?php get_template_part('partials/press-room', 'sidebar');?>
        </div>
    </div>
</div>
<?php get_footer('with-fractal');