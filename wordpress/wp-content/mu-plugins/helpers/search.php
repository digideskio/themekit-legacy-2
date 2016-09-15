<?
/**
 * Disable the Wordpress search form
 */
function disable_search_form() {
  return '<!-- WordPress search form is disabled -->';
}
add_filter('get_search_form', 'disable_search_form');

function search_sort_options() {
  global $datapress;
  if ( empty($datapress['payload']['search_params']['data_dict']['q']) ) {
    // Default option at top. Called "Last Modified" when no question is asked.
    return [
      "score desc, metadata_modified desc" => "Last Modified",
      "title_string asc"                   => "Name Ascending",
      "title_string desc"                  => "Name Descending",
    ]; 
  }
  // Default option at top. Different naming scheme:
  return [
    "score desc, dp_modified desc" => "Relevance",
    "metadata_modified desc"             => "Last Modified",
    "title_string asc"                   => "Name Ascending",
    "title_string desc"                  => "Name Descending",
  ]; 
}


function search_is_dataset() {
  return ! ( search_is_topic() || search_is_publisher() );
}

function search_is_topic() {
  global $datapress;
  return isset($datapress['payload']['type']) && $datapress['payload']['type'] == "group";
}

function search_is_publisher() {
  global $datapress;
  return isset($datapress['payload']['type']) && $datapress['payload']['type'] == "organization";
}


/*
 * Handle the bizarre OrderedDict from solr's spelling corrector.
 * Return:
 *  [  
 *   'correctlySpelled': boolean,
 *   'suggestion' : string or not set
 *  ]
 */
function search_parse_spelling($kv_list) {
  $out = [
    'correctlySpelled' => true
  ];

  for ($i = 0; $i < count($kv_list); $i += 2) {
    $key = $kv_list[$i];
    $value = $kv_list[$i+1];
    // Read an ordered set of k,v pairs
    if ($key=="correctlySpelled") { 
      $out['correctlySpelled'] = $value;
    }
    else if ($key=="collation") {
      continue;
    }
    else if ( isset($value['suggestion']) && count($value['suggestion']) ) {
      $out['suggestion'] = $value['suggestion'][0]['word'];
    }
  }
  return $out;
}

/*
 * Count the frequency of resource formats in a dataset.
 */
function count_resource_formats($resources) {
  $out = [];
  foreach ($resources as $res) {
    $f = $res['format'];
    $f = get_stylesheet_directory_uri()."/assets/images/filetypes/".$f.".png";
    if (array_key_exists($f,$out)) {
      $out[$f]++;
    }
    else {
      $out[$f] = 1;
    }
  }
  arsort($out);
  return $out;
}


/*
 * Count the frequency of res_geo fields in a dataset.
 */
function count_resource_geo($resources) {
  $out = [];
  foreach ($resources as $res) {
    if (isset($res['res_geo']) && ! empty($res['res_geo']) && is_array($res['res_geo']) ) {
      foreach ($res['res_geo'] as $geo) {
        if (array_key_exists($geo,$out)) {
          $out[$geo]++;
        }
        else {
          $out[$geo] = 1;
        }
      }
    }
  }
  arsort($out);
  return $out;
}
