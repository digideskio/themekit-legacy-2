<?
// Default settings
$hide_resources = false;
$hide_description = false;
$hide_size = true;
$truncate = 180;
$truncate_title = 80;

// Looks slightly different on the front page
if (array_key_exists('context', $dataset) && $dataset['context'] === 'widget') {
  $hide_size = false;
  $truncate = 256;
}

?>

<li class="dataset-item">
  <div class="dataset-content">

    <div class="dataset-modified">
      <small><i class="icon-time"></i> &nbsp;<?= created_or_modified( $dataset['metadata_created'], $dataset['metadata_modified'] ) ?></small>
    </div>

    <h3 class="dataset-heading">
      <div class="dataset-header-labels">
        <? if ($dataset['private']): ?>
          <span class="dataset-private alert alert-danger"><i class="icon-group"></i> Private</span>
        <? endif; ?>
        <? if (startsWith($dataset['state'],'draft')): ?>
          <span class="alert alert-info"><i class="icon-edit"></i> Draft</span>
        <? elseif (startsWith($dataset['state'],'deleted')): ?>
          <span class="alert alert-danger"><i class="icon-trash"></i> Deleted</span>
        <? endif; ?>
      </div>
      <?
        $title = $dataset['title'];
        if ( ! $title ) {
          $title = $dataset['name'];
        }
        $title = truncate($title, $truncate_title);
        $url = site_url("/dataset/{$dataset['name']}");
      ?>
      <a href="<?= $url ?>"><?= $title ?></a><?= $dataset['author'] ?>
    </h3>

    <? if ($dataset['notes'] && ! $hide_description): ?>
      <div class="dataset-description">
        <?= truncate(strip_tags($dataset['notes']), $truncate); ?>
      </div>
    <? endif; ?>

  </div><!-- /dataset-content -->

  <? if ( ! $hide_resources ): ?>
    <div class="dataset-resources">
      <? $formats = count_resource_formats($dataset['resources']); ?>
      <? foreach ( $formats as $img_url => $count ): ?>
        <span class="format-icon-group">
          <? for ($i=0; $i<$count && $i<3; $i++): ?>
            <img src="<?= $img_url ?>" class="format-icon format-icon-small" />
          <? endfor; ?>
          <? if ($count > 1): ?>
            &times; <?= $count ?>
          <? endif; ?>
        </span>
      <? endforeach; ?>

      <? if ( ! $hide_size ): ?>
        <?
          $size = 0;
          foreach ($dataset['resources'] as $res) {
            $size += $res['size'];
          }
        ?>
        <? if ($size >= 10): ?>
          <small class=\"dataset-filesize\">(<?= human_filesize($size) ?>)</small>";
        <? endif; ?>
      <? endif; ?>

    </div>

    <? $geo = count_resource_geo($dataset['resources']); ?>
    <? if (! empty($geo) ): ?>
      <ul class="dataset-resources list-unstyled">
        <? foreach ( $geo as $geo_item => $count ): ?>
          <li><span class="label label-default"><?= $geo_item ?><? if ($count>1) { ?>&nbsp; (<?= $count ?>)<? } ?></span></li>
        <? endforeach; ?>
      </ul>
    <? endif; ?>

  <? endif; ?><? /* if (hide_resources) */ ?>
  <hr />

</li>
