<? 
/* 
 * Used to render the front page. 
 * By default this shows whatever is defined in the database; we
 * have installed Bootstrap swatches for useful testing in ThemeKit.
 */ ?>

<main class="main" role="main">
  <?php while (have_posts()) : the_post(); ?>
    <?php the_content(); ?>
  <?php endwhile; ?>
</main>
