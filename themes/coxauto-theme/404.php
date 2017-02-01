<?php
/**
 * Default 404 Template
 *
 * @author
 * @package Cox_Automotive_Theme
 * @version $Id$
 */
get_header();?>

    <div class="container hfeed 404-body">
        <div class="row">
            <div class="404-message col-xs-12 vs-xs-top-3 vs-xs-top-6">
                <h1 class="404-title vs-xs-bottom-1 vs-lg-bottom-3">404 Not Found</h1>
                <div class="404-message-content">
                    <p class="vs-xs-bottom-1">Haven't found what you're looking for?</p>
                    <p><?php get_search_form(); ?></p>
                </div>
            </div>
        </div>
    </div>

<?php get_footer('with-fractal');