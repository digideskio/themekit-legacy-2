<? foreach ( $solr['search_facets'] as $facet_data ): ?>
  <? $facet = $facet_data['title']; ?>
  <? if ( search_is_topic() && $facet=='groups') {
   continue;
  } ?>
  <? if ( search_is_publisher() && $facet=='organization') {
    continue;
  } ?>
  <? include(locate_template('snippets/facet.php')); ?>
<? endforeach; ?>
