<?php
/**
 * Search form template
 *
 * @author Jess Green <jgreen@periscope.com>
 * @package Cox_Automotive_Theme
 */
?>
<form action="<?php echo home_url('/'); ?>" method="get">
    <label for="search" class="sr-only">Search</label>
    <input class="form-control" type="search" name="s" id="search" placeholder="Search" value="<?php the_search_query(); ?>" />
    <input type="hidden" value="post" name="post_type" id="posts" />
</form>
