<?/* Used to render random pages.  */ ?>

<?/* Uncomment if you want a sidebar:
     ================================

<aside class="sidebar" role="complementary">
...
</aside>
 */ ?>

 <main class="main <? /* sidebar-primary */?>" role="main">
  <?php while (have_posts()) : the_post(); ?>
    <article <?php post_class(); ?>>
      <header>
        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php get_template_part('templates/entry-meta'); ?>
      </header>
      <div class="entry-summary">
        <?php the_content(); ?>
      </div>
    </article>
  <?php endwhile; ?>
</main>
