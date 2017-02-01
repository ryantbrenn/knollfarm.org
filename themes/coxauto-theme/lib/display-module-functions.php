<?php
/**
 * Display Module functions
 *
 * @package Cox_Automotive_Theme
 * @author Jess Green <jgreen@periscope.com>
 */


/**
 * Output display module CSS classes
 *
 * @param int $id Display module ID
 * @param array|string $additional_classes Optional. Additional classes to attach to display module
 */
function coxauto_display_module_class($id = '', $additional_classes = '')
{
    if (!$id) {
        global $post;
        $id = get_post_field('ID', $post);
    }

    $classes = coxauto_get_display_module_class($id);
    if (is_array($additional_classes)) {
        $additional_classes = implode(' ', $additional_classes);
    }

    $classes = trim($additional_classes . " {$classes}");

    echo "class=\"{$classes}\"";
}


/**
 * Get classes and concatenate into a string
 *
 * @param int $id Display module ID
 * @return string
 */
function coxauto_get_display_module_class($id)
{

    $type = coxauto_get_display_module_type($id);

    $class[] = 'display-module';
    $class[] = 'display-module-' . $id;
    $class[] = "display-module-{$type}";  // ie: display-module-standard, display-module-video, etc.
    $class[] = get_field('display_module_text_color');
    $class[] = get_field('display_css_classes', $id);

    return trim(implode(" ", $class));
}

/**
 * Get the animation selected for the given display module.
 *
 * @param int $id Display module ID
 * @return string
 */
function coxauto_get_display_module_animation_classes($id = '')
{
    if (!$id) {
        global $post;
        $id = get_post_field('ID', $post);
    }

    $classes = array();

    $animation_class = get_field('display_module_animation', $id);

    if ($animation_class != 'none' and $animation_class !== NULL) {
        $classes[] = 'wow';
        $classes[] = $animation_class;
    }

    return trim(implode(' ', $classes));
}


/**
 * Get button classes
 *
 * @param int $id Display module ID
 * @return string
 */
function coxauto_get_diplay_module_button_classes($id)
{
    $classes = array_map('sanitize_html_class', explode(' ', get_field('module_button_style', $id)));

    return trim(implode(' ', $classes));
}


/**
 * Output class attribute containing button classes
 *
 * @param int $id Display module ID
 * @param array|string $additional_classes Optional. Additional classes to attach to button
 * @return string
 */
function coxauto_display_module_button_class($id = '', $additional_classes = '')
{
    if (!$id) {
        global $post;
        $id = get_post_field('ID', $post);
    }

    $classes = coxauto_get_diplay_module_button_classes($id);

    if (is_array($additional_classes)) {
        $additional_classes = implode(' ', $additional_classes);
    }

    $classes = trim($additional_classes . " {$classes}");

    echo "class=\"{$classes}\"";
}

/**
 * Get display module type
 *
 * @param int $id Display Module ID
 * @return string
 */
function coxauto_get_display_module_type($id)
{
    return (get_field('display_module_type', $id)) ? get_field('display_module_type', $id) : 'standard';
}


/**
 * Display text orientation class
 */
function coxauto_text_orientation()
{
    global $post;

    $text_orientation = coxauto_get_text_orientation(get_post_field('ID', $post));
    echo " {$text_orientation}";
}


/**
 * Get text orientation field class
 *
 * @param int $id Post ID
 * @return string
 */
function coxauto_get_text_orientation($id = false)
{
    if (!$id) {
        global $post;
        $id = get_post_field('ID', $post);
    }

    $orientation = get_post_meta($id, 'display_module_text_orientation', true);
    $text_orientation = ($orientation) ? $orientation : 'center-left';

    return $text_orientation;
}


/**
 * Output breakpoint-specific styling for display modules
 *
 * @param int $id
 * @param string|bool|false $parent_class
 * @param string|bool|false $target_class
 * @param string|false      $height_mode          Whether to add height rules of based on each image to the output CSS.
 * @param string|bool|false $height_mode_target   Element selector to add the height rule too. Defaults to $parent_class and $target_class combination.
 */
function coxauto_display_module_embedded_style($id = false, $parent_class = false, $target_class = false, $height_mode = false, $height_mode_target = false)
{
    if (!$id) {
        global $post;
        $id = get_post_field('ID', $post);
    }

    $background_video = get_field('display_module_background_video_url', $id);
    $background_video_width = get_field('display_module_background_video_width', $id);
    $background_video_height = get_field('display_module_background_video_height', $id);

    $breakpoints = get_field('display_module_image', $id);
    $defined_breakpoints = array(
        'media-xs' => 480,
        'media-sm' => 768,
        'media-md' => 992,
        'media-lg' => 1200,
    );

    $parent_class = ($parent_class) ? $parent_class : '.display-module-' . $id;
    $selector = trim($parent_class . ' ' . $target_class);

    $height_mode_target = ($height_mode_target) ? trim($parent_class . ' ' . $height_mode_target) : $selector;

    if (empty($breakpoints)) {
        $attachment_id  = get_post_thumbnail_id($id);
        if (!$attachment_id) {
            return;
        }

        $asset_root_url = coxauto_get_assets_root_url($attachment_id);
        $image_meta     = wp_get_attachment_metadata($attachment_id);

        $sizes = false;
        if (isset($image_meta['sizes'])) {
            $sizes = $image_meta['sizes'];
        }


        $fallback_image = esc_url($asset_root_url . basename($image_meta['file']));
        $fallback_image_height = $image_meta['height'];

        $large = isset($sizes['large']['file']) ? esc_url($asset_root_url) . $sizes['large']['file'] : $fallback_image;
        $large_image_height = isset($sizes['large']['file']) ? $sizes['large']['height'] : $fallback_image_height;

        $medium = isset($sizes['medium']['file']) ? esc_url($asset_root_url) . $sizes['medium']['file'] : $fallback_image;
        $medium_image_height = isset($sizes['medium']['file']) ? $sizes['medium']['height'] : $fallback_image_height;
    }
    ?>

    <style type="text/css" id="style-display-module-<?php echo $id; ?>">
        <?php if (empty($breakpoints)) : ?>
            @media (min-width: 992px) {
                <?php echo $selector; ?> {
                    background-image: url('<?php echo $fallback_image; ?>');
                }

                <?php if($height_mode == 'image-height'):
                    echo $height_mode_target; ?> {
                        height: <?php echo $fallback_image_height?>px;
                    }
                <?php endif; ?>
            }

            @media (max-width: 991px) and (min-width: 320px) {
                <?php echo $selector; ?> {
                    background-image: url('<?php echo $large; ?>');
                }

                <?php if($height_mode == 'image-height'):
                    echo $height_mode_target; ?> {
                        height: <?php echo $large_image_height ?>px;
                    }
                <?php endif; ?>
            }

            @media (max-width: 319px) {
                <?php echo $selector; ?> {
                    background-image: url('<?php echo $medium; ?>');
                }

                <?php if($height_mode == 'image-height'):
                    echo $height_mode_target; ?> {
                        height: <?php echo $medium_image_height ?>px;
                    }
                <?php endif; ?>
            }
        <?php else :
            foreach ($breakpoints as $i => $breakpoint) :
                $image = $breakpoint['module_breakpoint_image'];

                // If no image was set for this breakpoint, move on, there is nothing to output.
                if ($image === false) {
                    continue;
                }

                if ($i != 0) : ?>
                    @media (min-width: <?php echo $defined_breakpoints[$breakpoint['module_breakpoint_size']] ;?>px) {
                <?php endif;
                        echo $selector; ?> {
                            background-image: url('<?php echo esc_url($image['url']); ?>');
                        }

                        <?php if($height_mode !== false):
                            echo $height_mode_target; ?> {
                                <?php switch($height_mode):
                                    case 'image-height': ?>
                                        height: <?php echo $image['height']?>px;
                                        <?php break;
                                    case 'image-ratio': ?>
                                        height: 0;
                                        <?php if ($background_video && $breakpoint['module_breakpoint_size'] != 'media-xs'): ?>
                                            padding-bottom: <?php echo ($background_video_height / $background_video_width) * 100 ?>%;
                                        <?php else: ?>
                                            padding-bottom: <?php echo ($image['height'] / $image['width']) * 100 ?>%;
                                    <?php
                                        endif;
                                        break;
                                 endswitch; ?>
                            }
                        <?php endif; ?>
                <?php if ($i != 0): ?>
                    }
                <?php endif; ?>

            <?php endforeach;
        endif;

        /**
         * display_module_add_style
         * Use this action to add additional media queries or styles for each display module
         *
         * @param int $id Post ID
         * @param string $parent_class Parent class of element
         * @param string $target_class Target class of element
         * @param string $size Image thumbnail size
         * @param string $ratio Image thumbnail ratio
         */
        do_action('display_module_add_style', $id, $parent_class, $target_class);
        ?>
    </style>
    <?php
}
