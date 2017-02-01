<?php
/**
 * Single Post template
 *
 * @package Cox_Automotive_Theme
 * @author Jess Green <jgreen@periscope.com>
 */
get_header(); ?>

<div class="container vs-sm-top-6 vs-xs-top-3">
    <section class="row press-room-detail">
        <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class('col-md-8 col-md-offset-1'); ?>>
                <header class="article-header vs-md-bottom-6 vsp-md-bottom-6 vs-xs-bottom-3">
                    <div class="meta h3">
                        <time><?php the_time('F j, Y'); ?></time>
                    </div>
                    <h1 class="entry-title vs-xs-bottom-3"><?php the_title(); ?></h1>
                    <div class="subhead h2"><?php echo apply_filters('coxauto_subhead', get_field('subhead')); ?></div>

                    <?php if (has_post_thumbnail()) : ?>
                    <div class="post-thumbnail vs-xs-top-3 vs-md-top-6">
                        <?php $featured_images = coxauto_get_featured_images(get_the_ID()); ?>

                        <?php if (count($featured_images) <= 1) : ?>
                            <?php the_post_thumbnail(); ?>
                        <?php else : ?>
                            <div id="carousel-<?php the_ID(); ?>" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                <?php for ($i = 0 ; $i < count($featured_images) ; $i++) : ?>
                                    <li <?php echo (($i == 0) ? 'class="active"' : ''); ?> data-target="#carousel-<?php the_ID(); ?>" data-slide-to="<?php echo $i; ?>"></li>
                                <?php endfor; ?>
                                </ol>
                                <div class="carousel-inner" role="listbox">
                                    <?php foreach ($featured_images as $i => $image) : ?>
                                        <div class="item<?php echo (($i == 0) ? ' active' : ''); ?>"><?php echo $image; ?></div>
                                    <?php endforeach; ?>
                                </div>
                                <!-- Left and right controls -->
                                <a class="left carousel-control" href="#carousel-<?php the_ID(); ?>" role="button" data-slide="prev">
                                    <span class="fa fa-angle-left" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control" href="#carousel-<?php the_ID(); ?>" role="button" data-slide="next">
                                    <span class="fa fa-angle-right" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </header>
                <aside class="col-xs-12 col-md-2 sharing-buttons">
                    <h3 class="sharing-menu-label vs-md-bottom-3">Share</h3>
                    <ul class="sharing-menu">
                        <li><a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo esc_url(wp_get_shortlink()); ?>&amp;t=<?php echo urlencode(get_the_title()); ?>" class="fa fa-facebook-official"><span class="label sr-only">Facebook</span></a></li>
                        <li><a target="_blank" href="https://twitter.com/share?url=<?php echo esc_url(wp_get_shortlink()); ?>&amp;text=<?php echo urlencode(get_the_title()); ?>" class="fa fa-twitter"><span class="label sr-only">Twitter</span></a></li>
                        <li><a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url(get_permalink()); ?>&amp;title=<?php echo urlencode(get_the_title()); ?>&amp;summary=<?php echo urlencode(coxauto_get_excerpt_without_readmore()); ?>" class="fa fa-linkedin"><span class="label sr-only">LinkedIn</span></a></li>
                        <li><a target="_blank" href="mailto:?subject=<?php echo urlencode(strip_tags(get_the_title())) ?>&amp;body=<?php echo urlencode(coxauto_get_excerpt_for_email()); ?>" class="fa fa-envelope-o"><span class="label sr-only">Email</span></a></li>
                    </ul>
                </aside>

                <div class="wp-editor js-open-content-links-externally col-xs-12 col-md-10">
                    <?php the_content(); ?>
                </div>
            </article>

        <?php endwhile; ?>
        <div class="col-xs-12 col-md-3 pr-sidebar">
            <h2 class="vs-xs-bottom-6">Related Posts</h2>
            <?php $related_posts = new WP_Query(array('post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 4, 'post__not_in' => array(get_the_ID()))); ?>

            <?php if ($related_posts->have_posts()) : ?>
            <div class="related-posts">
                <?php while($related_posts->have_posts()) : $related_posts->the_post(); ?>
                    <?php $the_date = the_date('', '', '', false); ?>
                    <?php if ($the_date) : ?>
                        <h3 class="the-date h3"><?php echo $the_date; ?></h3>
                    <?php endif; ?>

                        <div class="related-post-item vs-xs-bottom-3 vsp-xs-bottom-3"><a href="<?php the_permalink(); ?>" class="h2"><?php the_title();?></a></div>

                <?php endwhile; ?>
            </div>
            <?php endif; wp_reset_query(); wp_reset_postdata() ?>
        </div>
    </section>
</div>
<?php get_footer('with-fractal');