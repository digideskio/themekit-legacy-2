<section class="publisher-sidebar">
  <div class="center-block sidebar-img">
    <img class="center-block img-responsive" src="<?= $datapress['payload']['image_url'] ?>" />
  </div>
  <ul>
    <?= li_link( 
      site_url("/publisher/{$datapress['payload']['name']}"), 
      "<i class=\"icon-sitemap\"></i> Datasets"
    ); ?>
    <?= li_link( 
      site_url("/publisher/activity/{$datapress['payload']['name']}"), 
      "<i class=\"icon-time\"></i> Activity Stream"
    ); ?>
    <? if ($datapress['payload']['auth']['organization_update']): ?>
      <?= li_link( 
        site_url("/publisher/edit/{$datapress['payload']['name']}"), 
        "<i class=\"icon-edit\"></i> Manage Metadata" . admin_label()
      ); ?>
    <? endif; ?>
    <? if ($datapress['payload']['auth']['organization_member_create']): ?>
      <?= li_link( 
        site_url("/publisher/members/{$datapress['payload']['name']}"), 
        "<i class=\"icon-group\"></i> Manage Users" . admin_label()
      ); ?>
    <? endif; ?>
<!-- hi! -->

    <? if ( ! empty($datapress['payload']['description']) ): ?>
    <li>
      <blockquote class="description description-publisher">
        <?= $datapress['payload']['description'] ?>
      </blockquote>
    </li>
    <? endif; ?>

  </ul>
</section>
