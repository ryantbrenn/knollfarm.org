<?php
/**
 * Press Room staff partial template
 *
 * @author Jess Green <jgreen@periscope.com>
 * @package Cox_Automotive_Theme
 */

if (have_rows('pr_staff_sidebar', $page_ID)) : ?>
    <ul class="pr-list">
        <h2 class="vs-xs-bottom-6">Media Inquiries</h2>
        <?php while (have_rows('pr_staff_sidebar', $page_ID)) : the_row(); ?>

            <li class="pr-item">
                <img class="vs-xs-bottom-3" src="<?php the_sub_field('pr_staff_image');?>" alt="<?php esc_attr_e(get_sub_field('pr_staff_name')) ?>" width="33%" height="33%">
                <strong class="pr-name"><?php the_sub_field('pr_staff_name') ?></strong>
                <div class="pr-brand"><?php the_sub_field('pr_staff_brand') ?></div>
                <div class="pr-title"><?php the_sub_field('pr_staff_title'); ?></div>
                <div class="pr-contact">
                    <a href="tel:<?php esc_attr_e(get_sub_field('pr_staff_phone')) ?>"><?php the_sub_field('pr_staff_phone') ?></a><br />
                    <a href="mailto:<?php esc_attr_e(get_sub_field('pr_staff_email')); ?>"><?php the_sub_field('pr_staff_email'); ?></a>
                </div>
            </li>

        <?php endwhile; ?>
    </ul>
<?php endif; ?>
