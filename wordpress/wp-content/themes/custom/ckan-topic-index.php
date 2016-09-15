<main>
  <div class="row">
    <? foreach ($datapress['payload'] as $polaroid) {
      $polaroid['href'] = site_url("/topic/{$polaroid['name']}");
      include(locate_template('snippets/polaroid.php'));
    } ?>
  </div>
</main>
