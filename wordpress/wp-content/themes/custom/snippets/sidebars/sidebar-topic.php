<section class="topic-sidebar">
  <div class="center-block sidebar-img">
    <img class="img-responsive" src="<?= $datapress['payload']['image_url'] ?>" />
  </div>
  <ul>
    <?= li_link( 
      site_url("topic/{$datapress['payload']['name']}"), 
      "<i class=\"icon-sitemap\"></i> Datasets"
    ); ?>
    <?= li_link( 
      site_url("topic/activity/{$datapress['payload']['name']}"), 
      "<i class=\"icon-time\"></i> Activity Stream"
    ); ?>
  </ul>
</section>
