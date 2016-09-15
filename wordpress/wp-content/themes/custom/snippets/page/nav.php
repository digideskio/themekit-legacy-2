<?php use Roots\Sage\Nav\NavWalker; ?>
<?php use DataPress\ActionsBar; ?>

<div class="navbar-bar">
  <nav class="navbar navbar-default" role="navigation">
    <div class="container">
      <?php
      if (has_nav_menu('primary_navigation')) :
        // Wordpress will build a nav from menu from 'primary navigation' menu.
        wp_nav_menu([
          'theme_location' => 'primary_navigation',
          'walker'         => new NavWalker(),
          'menu_class'     => 'nav navbar-nav',
          // Uncomment to add Login/Action buttons as items in the nav bar.
          // 'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s'.ActionsBar\get_nav_options().'</ul>',
        ]);
      endif;
      ?>
    </div>
  </nav>
</div>
