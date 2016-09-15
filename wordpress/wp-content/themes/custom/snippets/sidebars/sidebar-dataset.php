<section class="dataset-sidebar-nav">
  <ul>
    <?= li_link( 
     site_url("/dataset/{$datapress['payload']['name']}"), 
     "<i class=\"icon-sitemap\"></i> View Dataset"
    ); ?>
    <?= li_link( 
     site_url("/dataset/activity/{$datapress['payload']['name']}"), 
     "<i class=\"icon-time\"></i> Activity Stream"
    ); ?>
    <? if ($datapress['payload']['auth']['package_update']): ?>
      <?= li_link( 
         site_url("/dataset/resources/{$datapress['payload']['name']}"), 
         "<i class=\"icon-reorder\"></i> Manage Files" . admin_label()
       ); ?>
      <?= li_link( 
         site_url("/dataset/edit/{$datapress['payload']['name']}"), 
         "<i class=\"icon-edit\"></i> Manage Metadata" . admin_label()
       ); ?>
    <? endif; ?>
  </ul>
</section>

<section class="dataset-sidebar-publisher">
  <h2>Publisher</h2>
  <ul>
    <li>
      <div class="center-block sidebar-img">
        <a href="<?= site_url("/publisher/{$datapress['payload']['organization']['name']}"); ?>">
          <? if (empty($datapress['payload']['organization']['image_url'])): ?>
            <h4 style="padding: 20px 10px;"><?=$datapress['payload']['organization']['title']?></h4>
          <? else: ?>
            <img class="center-block img-responsive" src="<?= $datapress['payload']['organization']['image_url'] ?>" />
          <? endif; ?>
        </a>
      </div>
    </li>
  </ul>
</section>

<? if ( ! empty($datapress['payload']['more_like_this']) ): ?>
  <section class="dataset-sidebar-more">
    <h2>More Like This...</h2>
    <ul>
      <? foreach  ($datapress['payload']['more_like_this'] as $more): ?>
        <li><a href="<?= site_url("/dataset/{$more[0]}"); ?>"><i class="icon-sitemap"></i>&nbsp; <?= $more[1] ?></a></li>
      <? endforeach; ?>
    </ul>
  </section>
<? endif; ?>
