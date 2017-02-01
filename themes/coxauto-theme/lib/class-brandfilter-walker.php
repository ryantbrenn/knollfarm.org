<?php
/**
 * BrandFilter Walker class
 *
 * @package Cox_Automotive_Theme
 * @author Jess Green <jgreen@periscope.com>
 */

/**
 * Class BrandFilter_Walker
 */
class BrandFilter_Walker extends Walker_Category
{
    /**
     * @see Walker_Category::start_lvl
     */
    public function start_lvl( &$output, $depth = 0, $args = array() )
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent<ul class='list-unstyled children dropdown'>\n";
    }


    /**
     * @see Walker_Category::end_lvl
     */
    public function end_lvl( &$output, $depth = 0, $args = array() )
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }


    /**
     * @see Walker_Category::start_el
     */
    public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 )
    {
        static $top_level_count, $sub_level_count;

        $is_child = boolval($category->parent);

        if (!$is_child) {
            $top_level_count++;
            $sub_level_count = 0;
        } else {
            $sub_level_count++;
        }

        // only three items top-level and only 5 items on
        // the second level are allowed
        if ($top_level_count > 3 || $sub_level_count > 5) {
            $output .= '';
            return;
        }

        $children = get_terms(
            $category->taxonomy,
            array(
                'parent' => $is_child ? $category->parent : $category->term_id,
            )
        );

        $total_children = (count($children) > 5) ? 5 : count($children);
        $has_children = !empty($children);
        $total_columns = !$is_child ? $total_children : $total_children - 1;

        $data_toggle = '';
        $link_classes = array('btn', 'btn-primary', 'btn-contents');
        if ($has_children) {
            $data_toggle = ' data-toggle="dropdown" ';
            $link_classes[] = 'dropdown-toggle';
        }

        if ($is_child) {
            $link_classes[] = 'keep-open';
        }

        $cat_name = apply_filters(
            'list_cats',
            esc_attr( $category->name ),
            $category
        );

        $link = '<a href="#" class="' . implode(' ', $link_classes) . '"' . $data_toggle . 'data-filter="' . esc_attr($category->slug) . '">';
        $link .= $cat_name;
        // add Bootstrap hit-state button
        if ($has_children && !$is_child) {
            $link .= '<i class="clickable hidden-md hidden-lg dropdown-toggle fa dropdown-toggle-icon"></i>';
        }
        $link .= '</a>';

        $output .= "\t";
        if ($has_children && !$is_child) {
            $output .= "<li class=\"dropdown item-columns-{$total_columns}\" data-debug=\"{$total_children}\">$link\n";
        } else {
            $output .= "<li>$link\n";
        }
   }

}