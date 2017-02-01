<?php
/**
 * Large Image/Video module
 *
 * @package Cox_Automotive_Theme
 * @author Jess Green <jgreen@periscope.com>
 */

$headline = apply_filters('the_title', get_field('display_module_headline'));
$sub_head = esc_textarea(get_field('display_module_sub_head'));
$height_mode = get_field('display_module_height_mode');

$hero_class = 'hero';
switch(coxauto_get_text_orientation()) {
    case 'center-left':
        $hero_class .= '--left';
        break;
    case 'center-center':
        $hero_class .= '--center';
        break;
    case 'center-right':
        $hero_class .= '--right';
        break;
}

$hero_classes = array($hero_class);

switch ($height_mode) {
    case 'image-height':
        coxauto_display_module_embedded_style(false, false, false, $height_mode, '.hero__spacer');
        break;

    case 'image-ratio':
        $hero_classes[] = 'hero--ratio';
        coxauto_display_module_embedded_style(false, false, false, $height_mode);
        break;

    case 'full-screen':
        $hero_classes[] = 'hero--full-height';
        coxauto_display_module_embedded_style();
        break;

    default:
        coxauto_display_module_embedded_style();
}

if (!get_field('module_button_use_external_url')) {
    $link = get_field('module_button_internal_url');
} else {
    $link = get_field('module_button_external_url');
}

if (!get_field('module_button_open_new_window')) {
    $target = "";
} else {
    $target = " target=\"_blank\"";
}
$video_url = trim(get_field('display_module_background_video_url'));

if ($video_url) {
    $hero_classes[] = 'hero--with-video';
}

?>
<div <?php coxauto_display_module_class(false, $hero_classes)?> <?php if($video_url): ?>data-vide-bg="<?php echo $video_url ?>" data-vide-options="posterType: none"<?php endif; ?>>
    <div class="container hero__container">
        <div class="row">
            <div class="hero__spacer"></div>
            <div class="hero__body--constrained wp-editor <?php echo coxauto_get_display_module_animation_classes() ?>">
                <?php echo apply_filters('the_display_module_content', get_field('display_module_content')); ?>
            </div>
        </div>
    </div>

    <?php if(get_field('use_button_cta')): ?>
        <a href="<?php echo $link; ?>" <?php echo $target; ?> <?php coxauto_display_module_button_class(false, 'hero__cta hidden-xs') ?>><?php the_field('module_button_text'); ?></a>
    <?php endif; ?>
</div>

