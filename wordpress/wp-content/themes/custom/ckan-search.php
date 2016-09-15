<?
$solr = $datapress['payload']['package_search'];

// Sort facets by the 'index' parameter
usort($solr['search_facets'], function($a,$b) {
  return $a['index'] - $b['index'];
});

$search_params = $datapress['payload']['search_params'];
$query_text = isset($search_params['query_text']) ? $search_params['query_text'] : '';
$no_query = (empty($search_params['active_facets'])) && (empty($query_text));

?>

<form id="dp-search-engine">

<aside class="sidebar" role="complementary">
  <? 
  /* Include the sidebar's top part */
  if (search_is_publisher()) {
    include(locate_template("snippets/sidebars/sidebar-publisher.php"));
  }
  if (search_is_topic()) {
    include(locate_template("snippets/sidebars/sidebar-topic.php"));
  }
  include(locate_template("snippets/sidebars/sidebar-search.php"));
  ?>

</aside><!-- /.sidebar -->

<main class="main sidebar-primary" role="main">
  <?
      /* Include the main header for this content type */
  if (search_is_publisher()) {
    ?>
    <div class="pull-right follow-button-container">
      <? render_follow_button("publisher",$datapress['payload']['name']); ?>
    </div>
    <h1 class="publisher-header"><?= $datapress['payload']['title'] ?></h1>
    <?
  }
  if (search_is_topic()) {
    ?>
    <div class="pull-right follow-button-container">
      <? render_follow_button("topic",$datapress['payload']['name']); ?>
    </div>
    <h1 class="topic-header"><?= $datapress['payload']['title'] ?></h1>
    <?
  }
  ?>

  <div class="input-group dp-main-search">
    <input class="search input-lg form-control" name="q" placeholder="Search datasets..." type="text" value="<?= htmlspecialchars($query_text); ?>"/> 
    <span class="input-group-btn">
      <button class="btn btn-default btn-lg" type="submit" value="search"><i class="icon-search"></i></button>
    </span>
  </div>

  <div class="<?= count($solr['results'])==0 ? "hidden" : ""; ?> m-top pull-right form-inline form-group dp-sort">
    <label for="field-order-by">Sort By:</label>
    <select id="field-order-by" name="sort" class="form-control" data-widget="SubmitOnChange">
      <? foreach (search_sort_options() as $key=>$value): ?>
        <option value="<?= $key ?>" <?= $solr['sort']==$key? 'selected="selected"':''?>><?=$value?></option>
      <? endforeach; ?>
    </select>
  </div>


  <h2><? printf( __('%d Datasets Found', 'sage'), $solr['count']); ?></h2>
  <? $spelling = search_parse_spelling($solr['spelling']); ?>
  <? if ( ! $spelling['correctlySpelled'] ): ?>
    <div class="dp-spelling-suggestion">
      <small><? sprintf( __('Did you mean <a href="$1%s">$2%s</a>?', 'sage'), querystring_link("q", $spelling['suggestion']), $spelling['suggestion'] ); ?></small>
    </div>
  <? endif; ?>
  
  <ul class="dataset-list list-unstyled">
    <?
      foreach ($solr['results'] as $dataset):
        include(locate_template('snippets/dataset-search-result.php'));
      endforeach;
    ?>
  </ul>
  <? unset($solr['results']); ?>


  <? if (search_is_dataset() && $no_query): ?>
    <? /* Align with the other pagination elements */ ?>
    <div class="pagination pull-right">
      <div class="btn-group">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="icon-folder-open"></i>&nbsp; <? _e('Site Downloads', 'sage'); ?> <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-right">
          <li>
            <a href="/api/rest/dump/catalogue.xlsx">
              <img class="format-icon format-icon-small" src="<?= get_template_directory_uri() ?>/assets/images/filetypes/xlsx.png"/>&nbsp;
              <? _e('Excel Data Dump', 'sage'); ?>
            </a>
          </li>
          <li>
            <a href="/api/rest/dump/catalogue.zip">
              <img class="format-icon format-icon-small" src="<?= get_template_directory_uri() ?>/assets/images/filetypes/zip.png"/>&nbsp;
              <? _e('CSV Data Dump', 'sage'); ?>
            </a>
          </li>
          <?  if ( is_site_administrator() ): ?>
            <li role="separator" class="divider"></li>
            <li>
              <a href="/api/rest/dump/admin-catalogue.xlsx">
                <img class="format-icon format-icon-small" src="<?= get_template_directory_uri() ?>/assets/images/filetypes/xlsx.png"/>&nbsp;
                <span class="label label-danger"> <i class="icon-exclamation-sign"></i>&nbsp; <? _e('Admin', 'sage'); ?></span> <? _e('Excel Data Dump', 'sage'); ?>
              </a>
            </li>
            <li>
              <a href="/api/rest/dump/admin-catalogue.zip">
                <img class="format-icon format-icon-small" src="<?= get_template_directory_uri() ?>/assets/images/filetypes/zip.png"/>&nbsp;
                <span class="label label-danger"> <i class="icon-exclamation-sign"></i>&nbsp; <? _e('Admin', 'sage'); ?></span> <? _e('CSV Data Dump', 'sage'); ?>
              </a>
            </li>
          <? endif; ?>
        </ul>
      </div>
    </div>
  <? endif; ?>

  <? render_pagination( $solr['count'], $search_params['data_dict']['start'], $search_params['data_dict']['rows'] ); ?>
</main>

</form><? /* #dp-search-engine */ ?>
