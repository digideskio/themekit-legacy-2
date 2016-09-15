<?
function facet_sidebar_sorted($facet,$facet_data) {
  global $datapress;
  $active_facets = $datapress['payload']['search_params']['active_facets'];
  // ----
  $items = $facet_data['items'];
  // Add 'active' class
  foreach (array_keys($items) as $k) {
    $name = $items[$k]['name'];
    $items[$k]['active'] = in_array($facet.":".$name,$active_facets);
    if ($facet === 'res_format') {
      $items[$k]['display_name'] = $items[$k]['name'];
    }
  }
  /*
   * Sort primarily by active (high weighting hack)
   * Secondarily by their score.
   * Could be done cleaner with multiple sorts, if PHP had 
   * a simple stable sort function in easy reach.
   */
  usort($items, function ( $a, $b ) {
    $score_1 = $a['count'] + ($a['active']?1000:0);
    $score_2 = $b['count'] + ($b['active']?1000:0);
    return $score_2 - $score_1;
  });
  return $items;
}


/* 
 * Uses payload: dp_search
 *
 * Render the display name for a facet.
 * eg. "res_geo" as "Resource Geography".
 */
function facet_display_key($key) {
  global $datapress;
  $titles = $datapress['payload']['search_params']['facet_titles'];
  if (array_key_exists($key,$titles)) {
    return $titles[$key];
  }
  return $key;
}


/* 
 * Uses payload: dp_search
 *
 * Render the display name for a facet entry.
 * eg. "census-information-scheme" as "Census Information Scheme".
 *
 * Gracefully breaks in the case when 0 search results appear.
 * Because the payload contains no facets!
 */
function facet_display_value($key,$value) {
  global $datapress;
  $facets = $datapress['payload']['package_search']['search_facets'];
  if (array_key_exists( $key, $facets ) ) {
    foreach ($facets[$key]['items'] as $item) {
      if ($item['name'] == $value) {
        return $item['display_name'];
      }
    }
  }
  return $value;
}

