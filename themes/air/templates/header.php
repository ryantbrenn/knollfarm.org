<header class="banner">
  <div class="container">
    <a class="brand" href="<?= esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
    <nav class="navbar navbar-full nav-primary">
      <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation"><span></span></button>
      <div class="collapse navbar-toggleable-xs" id="navbarCollapse">
          <?php
          if (has_nav_menu('primary_navigation')) :
            wp_nav_menu(['theme_location' => 'primary_navigation', 'walker' => new wp_bootstrap_navwalker(), 'menu_class' => 'nav navbar-nav']);
          endif;
          ?>
      </div>
    </nav>
  </div>
</header>
