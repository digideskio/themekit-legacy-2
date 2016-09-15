<?
define("MODE_DATASET_READ",true);
if ( ! defined("RESOURCE_DIRECT_LINKS") ) {
  define("RESOURCE_DIRECT_LINKS", false);
}
?>
  <aside class="sidebar" role="complementary">
    <? include(locate_template("snippets/sidebars/sidebar-dataset.php")); ?>
  </aside><!-- /.sidebar -->

  <main class="main sidebar-primary" role="main">
    <? get_template_part("snippets/dataset-read-title"); ?>

    <? if ( ! empty($datapress['payload']['notes']) ): ?>
      <div class="dp-dataset-description">
        <?= $datapress['payload']['notes'] ?>
      </div>
    <? endif; ?>

    <hr/>

    <h3><i class="icon-folder-open"></i> <? _e('Data and Resources', 'sage')?></h3>
    <ul class="list-unstyled resource-list">
      <? foreach ($datapress['payload']['resources'] as $resource): 
        $dataset_name = $datapress['payload']['name'];
        $resource_id = $resource['id'];
        $link_view = site_url("/dataset/{$dataset_name}/resource_read/{$resource_id}");
        $link_edit = site_url("/dataset/resources/{$dataset_name}?resource_id={$resource_id}");
        ?>
        <li class="resource-item" data-id="<?= $dataset_name ?>">
        <span class="hide" property="dc:format"><?= $resource['format']; ?></span><img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/filetypes/<?= $resource['format']; ?>.png" class="format-icon" />
          <div class="row">
            <div class="col-lg-10 col-md-9 col-sm-12">
              <? if ($datapress['payload']['auth']['package_update']): ?>
                <a class="pull-right hidden-xs hidden-sm btn btn-sm m-left btn-danger" href="<?= $link_edit ?>" title="<?= $resource['name'] ?>"><i class="icon-gears"></i>&nbsp; <? _e('Edit', 'sage')?></a>
              <? endif; ?>
              <? if (RESOURCE_DIRECT_LINKS): ?>
                <a href="<?= $resource['url'] ?>" title="<?= $resource['name'] ?>">
              <? else: ?>
                <a href="<?= $link_view ?>" title="<?= $resource['name'] ?>">
              <? endif; ?>
                  <strong><?= $resource['name'] ?></strong>
                </a>
              <? if ($resource['size']): ?>
                <span class=\"text-muted\">(<?= human_filesize($resource['size'])?>)</span>
              <? endif ?>
              <p class="description">
                <?= $resource['description']; ?>
                <? if (RESOURCE_DIRECT_LINKS): ?>
                  <span class="text-muted"><?= $resource['url']; ?></span>
                <? endif; ?>
              </p>
            </div>
            <div class="hidden-xs hidden-sm visible-md visible-lg col-md-3 col-lg-2">
              <div class="btn-group-vertical">
                <a class="text-left btn btn-sm btn-primary" href="<?= $link_view ?>" title="<?= $resource['name'] ?>"><i class="icon-bar-chart"></i>&nbsp; <? _e('Preview', 'sage')?></a>
                <a class="text-left btn btn-sm btn-primary" href="<?= $resource['url'] ?>" title="<?= $resource['name'] ?>"><i class="icon-download"></i>&nbsp; <? _e('Download', 'sage')?></a>
              </div>
            </div>
            <div class="visible-xs visible-sm hidden-md hidden-lg col-xs-12 text-right m-top">
              <? if ($datapress['payload']['auth']['package_update']): ?>
                <a class="btn btn-sm btn-danger" href="<?= $link_edit ?>" title="<?= $resource['name'] ?>"><i class="icon-gears"></i>&nbsp; <? _e('Edit', 'sage')?></a>
              <? endif; ?>
              <a class="btn btn-sm btn-primary" href="<?= $link_view ?>" title="<?= $resource['name'] ?>"><i class="icon-bar-chart"></i>&nbsp; <? _e('Preview', 'sage')?></a>
              <a class="btn btn-sm btn-primary" href="<?= $resource['url'] ?>" title="<?= $resource['name'] ?>"><i class="icon-download"></i>&nbsp; <? _e('Download', 'sage')?></a>
            </div>
          </div>
        </li>
      <? endforeach; ?>
    </ul>


    <? if ( ! empty($datapress['payload']['tags'])): ?>
      <hr/>

      <h3><i class="icon-tags"></i> <? _e('Tags', 'sage')?></h3>
      <div class="dataset-tags">
        <? foreach ($datapress['payload']['tags'] as $tag): ?>
          <? $tag_class = [ "label", "label-default", "dp-dataset-tag" ];
          ?>
            <a class="<?= implode(" ",$tag_class); ?>" href="<?= site_url("/dataset","search",["tags"=>$tag['name']]) ?>"><i class="icon-tag"></i>&nbsp; <?= $tag['display_name'] ?></a> &nbsp;
        <? endforeach; ?>
      </div>
    <? endif; ?>

    <hr/>

    <h3><i class="icon-legal"></i> <? _e('Licence', 'sage')?></h3>
    <? if ( empty($datapress['payload']['license_id']) ): ?>
      <em class="dp-licence-text empty"><? _e('No Licence Specified', 'sage')?></em>
    <? else: ?>
      <? if ( ! empty($datapress['payload']['license_url']) ): ?>
        <a class="dp-licence-link" href="<?=$datapress['payload']['license_url']?>">
      <? endif; ?>
      <span class="dp-licence-text"><?= $datapress['payload']['license_title'] ?></span>
      <? if ( ! empty($datapress['payload']['license_url']) ): ?>
        </a>
      <? endif; ?>
<? /* TODO render isopen */ ?>
    <? endif; ?>
    <? if ( ! empty($datapress['payload']['license_text']) ): ?>
      <blockquote style="text-indent: -0.33em;">&ldquo;<?= $datapress['payload']['license_text']; ?>&rdquo;</blockquote>
    <? endif; ?>

    <hr/>

    <h3><i class="icon-tasks"></i> <? _e('Additional Info', 'sage'); ?></h3>
    <? 
      $metadata_table = $datapress['payload'];
    ?>
    <table class="table table-bordered table-striped dp-metadata-table">
      <? foreach ($metadata_table as $key=>$val): ?>
        <tr>
          <th><?= $key ?></th>
          <td><?= $val ?></td>
        </tr>
      <? endforeach; ?>
    </table>

  </main>
