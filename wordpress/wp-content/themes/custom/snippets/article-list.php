<article <?php post_class(); ?>>
  <header>
    <? if (has_post_thumbnail()) : ?>
      <a href="<?php the_permalink(); ?>" class="dp-thumbnail" style="background-image: url( <?= the_post_thumbnail_url; ?> ); height: 250px;">
    <? endif; ?>
    <h1 class="dp-thumbnail-caption entry-title"><?php the_title(); ?></h1>
    </a>
    <?php get_template_part('snippets/entry-meta'); ?>
  </header>
  <div class="entry-content">
    <?php the_excerpt(); ?>
  </div>
</article>
<hr />
