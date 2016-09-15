<?
/*
 * Return a URL of the current page plus an additional 
 * parameter, eg. ?$key=$value.
 *
 * Pass $append=true if building a multi-value facet:
 * ?tag=one,two,three
 */
function querystring_link($key,$value,$append=false) {
  $q = stripslashes_deep($_GET);
  unset($q['page']);
  if ( $append && ! empty($q[$key]) ) {
    $q[$key] .= ','.$value;
  }
  else {
    $q[$key] = $value;
  }
  return '?'.http_build_query($q);
}


/*
 * Return a URL of the current page minus a querystring key.
 * 
 * Pass a $value if subtracting from a multi-valued facet:
 * ?tag=one,three
 */
function querystring_unlink($key,$value=null) {
  $q = stripslashes_deep($_GET);
  unset($q['page']);
  if ($value!==null && ! empty($q[$key])) {
    $tmp = explode(",",$q[$key]);
    $tmp = array_diff($tmp, [$value]);
    if (count($tmp)) {
      $q[$key] = implode(",", $tmp);
    }
    else {
      unset($q[$key]);
    }
  }
  else {
    unset($q[$key]);
  }
  return '?'.http_build_query($q);
}


