<? /* Used to render lists of articles - by default the /posts page */ ?>

<aside class="sidebar" role="complementary">
  <?php include(locate_template('snippets/sidebars/sidebar-default.php')); ?>
</aside><!-- /.sidebar -->

<main class="main sidebar-primary" role="main">

  <? /* What to do if no post is found */ ?>

 <?php if (!have_posts()) : ?>
    <div class="alert alert-warning">
      <?php _e('Sorry, no results were found.', 'sage'); ?>
    </div>
  <?php endif; ?>

  <? /* and if post IS found... */ ?>

  <div>
    <?php 
      while (have_posts()) : the_post();
        include(locate_template('snippets/article-list.php'));
      endwhile;
    ?>
  </div>

  <? include(locate_template('snippets/pagination.php')); ?>

</main>
