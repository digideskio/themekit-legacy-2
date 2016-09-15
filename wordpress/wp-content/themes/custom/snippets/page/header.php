<?php use DataPress\ActionsBar; ?>

<header class="banner" role="banner">
  <div class="header-bar">
    <div class="container">
      <img id="brand-logo" src="<?= get_stylesheet_directory_uri(); ?>/assets/images/logo.png" />
      <h1 id="brand-title"><a href="<?= esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a></h1>
      <? get_template_part('snippets/actionsbuttons'); ?>
    </div>
  </div>
<?
    do_action('before_nav');
    get_template_part('snippets/page/nav');
    do_action('after_nav');

    do_action('before_breadcrumbs');
    get_template_part('snippets/page/breadcrumbs');
    do_action('after_breadcrumbs');
?>
</header>
