<? /* Used to render single posts */ ?>

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

  <?php while (have_posts()) : the_post(); ?>
    <article <?php post_class(); ?>>
      <header>
        <? if (has_post_thumbnail()): ?>
          <div class="dp-thumbnail" style="background-image: url( <?= the_post_thumbnail_url; ?> ); "></div>
        <? endif; ?>
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <?php get_template_part('snippets/entry-meta'); ?>
      </header>
      <div class="entry-content">
        <?php the_content(); ?>
      </div>
      <footer>
        <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
      </footer>
    </article>
  <?php endwhile; ?>

</main>
