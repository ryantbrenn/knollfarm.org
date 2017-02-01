<div class="container">
    <div class="row">
        <div class="col-md-9">
            <img src="<?php echo get_theme_mod('footer_image'); ?>" class="vs-xs-bottom-3 vs-md-bottom-0">
        </div>

        <?php wp_nav_menu(array(
                'theme_location' => 'social-media',
                'container'       => 'div',
                'container_class' => 'col-md-3',
                'menu_id'         => '',
                'menu_class'      => 'list-inline footer-social-icons',
        )); ?>
    </div>


    <div class="row">
        <div class="col-md-3 col-md-push-9">
            <?php
                $contactAddress = trim(get_theme_mod('footer_contact_address'));

                if ($contactAddress):
            ?>
                <p>
                    <?php echo nl2br($contactAddress); ?>
                </p>
            <?php endif; ?>

            <?php
                $emailContact = trim(get_theme_mod('footer_contact_email'));
                if ($emailContact):
            ?>
                <a href="mailto:<?php echo $emailContact; ?>" class="h3"><?php echo $emailContact; ?></a>
            <?php endif; ?>
        </div>

        <div class="col-md-9 col-md-pull-3 vs-xs-top-2">
            <?php wp_nav_menu(array(
                'theme_location' => 'footer-links',
                'container'       => false,
                'container_class' => '',
                'menu_id'         => '',
                'menu_class'      => 'footer-nav',
            )); ?>
            <p class="vs-xs-top-1">&copy;<?php echo date("Y"); ?> <?php echo trim(get_theme_mod('footer_copyright')); ?></p>
        </div>
    </div>

</div>
