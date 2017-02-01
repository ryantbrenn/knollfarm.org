<?php
/**
 * Display Module preview functions
 * @package Cox_Automotive_Theme
 * @author Jess Green <jgreen@periscope.com>
 */


/**
 * Enqueue needed scripts
 */
function coxauto_enqueue_admin_preview_scripts($hook)
{
    $screen = get_current_screen();
    if ($screen->post_type !== 'display_module' && $hook !== 'post.php') {
        return;
    }

    wp_enqueue_script(
        PERSK_TEXT_DOMAIN . '-post-preview',
        THEME_TEMPLATE_URL . '/assets/scripts/preview-in-page.js',
        array('jquery')
    );
}
add_action('admin_enqueue_scripts', 'coxauto_enqueue_admin_preview_scripts');


/**
 * Add fields to publish meta-box
 */
function coxauto_add_preview_in_page()
{
    /**
     * @global \wpdb $wpdb
     * @global \WP_Post $post
     */
    global $wpdb, $post;

    if (get_post_type($post) !== 'display_module') {
        return;
    }

    $post_id = get_post_field('ID', $post, 'db');

    // cache results?
    $raw_sql = "SELECT pm.post_id FROM {$wpdb->postmeta} pm "
               . "INNER JOIN {$wpdb->posts} p ON p.ID=pm.post_id AND p.post_status IN ('publish', 'draft') "
               . "WHERE pm.meta_value LIKE '%s'";
    $sql = $wpdb->prepare($raw_sql, '%"' . $wpdb->esc_like($post_id) . '"%');
    $results = $wpdb->get_results($sql);

    $ids = array();
    foreach ($results as $r) {
        if (get_post_type($r->post_id) !== 'display_module') {
            $ids[] = $r->post_id;
        }
    }

    if (!empty($ids)) : ?>
    <div class="misc-pub-section">
        <h4>Preview in Page</h4>
        <ul>
            <?php foreach ($ids as $id) :
                $parent_post = get_post($id);

                $page_url = set_url_scheme(get_permalink($id));
                $query = add_query_arg(array(
                    'preview' => 'true',
                    'preview-display-module' => $post_id,
                ), $page_url);

                $preview_link = esc_url(apply_filters('preview_post_link', $query, $parent_post ) );
                ?>

                <li><a data-page-id="<?php echo intval($id); ?>" class="display-module-preview" target="_blank" href="<?php echo $preview_link;  ?>"><?php echo apply_filters('the_title', get_post_field('post_title', $parent_post)) ?></a></li>

            <?php endforeach; ?>
        </ul>
        <input type="hidden" id="preview-in-page" name="preview-in-page" value="" />
    </div>
    <?php endif;
}
add_action('post_submitbox_misc_actions', 'coxauto_add_preview_in_page');


/**
 * Replace stored display module with preview version
 *
 * @param array $value Array of values
 * @param int $post_id
 * @param array $field
 * @return array
 */
function coxauto_filter_display_modules_loop_on_preview($value, $post_id, $field)
{
    $preview_display_module_id = filter_input(INPUT_GET, 'preview-display-module', FILTER_SANITIZE_NUMBER_INT);
    $autosave_post = wp_get_post_autosave($preview_display_module_id);
    if ($autosave_post) {
        foreach ($value as $i => $post) {
            if (get_post_field('ID', $post) == $preview_display_module_id) {
                $value[$i] = $autosave_post;
            }
        }
    }

    return $value;
}
add_filter('acf/format_value/name=page_display_modules', 'coxauto_filter_display_modules_loop_on_preview', 10, 3);


/**
 * Filter preview link for "Preview On Page" functionality
 *
 * @param string $url
 * @param \WP_Post $post
 * @return string
 */
function coxauto_preview_display_module_link($url, $post)
{
    if (empty(filter_input(INPUT_POST, 'preview-in-page'))) {
        return $url;
    }

    $parsed_url = parse_url($url);
    $query_vars = array();
    parse_str($parsed_url['query'], $query_vars);

    // need to add preview nonce
    $url = add_query_arg(array(
        'preview' => 'true',
        'preview-display-module' => get_post_field('ID', $post),
        'preview_nonce' => $query_vars['preview_nonce'],
    ), get_permalink(intval(filter_input(INPUT_POST, 'preview-in-page'))));

    return $url;
}
add_filter('preview_post_link', 'coxauto_preview_display_module_link', 10, 2);