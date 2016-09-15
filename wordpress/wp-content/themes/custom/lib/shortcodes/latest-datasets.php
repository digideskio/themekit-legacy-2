<?
function latest_datasets( $atts ){
  global $datapress;
  ob_start();
  ?>
  <div data-widget="CssScroll" class="latest-datasets">
    <ul class="dataset-list unstyled">
      <? foreach ($datapress['payload']['results'] as $dataset): ?>
        <? $dataset['context'] = "widget"; ?>
        <? include(locate_template('snippets/dataset-search-result.php')); ?>
      <? endforeach; ?>
    </ul>
  </div>
  <?
  return ob_get_clean();
}
add_shortcode( 'latest-datasets', 'latest_datasets' );

