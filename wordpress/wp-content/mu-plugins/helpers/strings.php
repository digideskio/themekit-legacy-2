<?
// These two functions are neessary for some dataset search things. TODO Find out if they need to be here rather than in lib somewhere
function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}
function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
}

/* 
 * Render 'Created X ago, modified X ago' 
 */
function created_and_modified( $created_iso, $modified_iso, $or_not_and=false ){
  if ( ! ($created_iso || $modified_iso) ) { 
    return;
  };

  $created = strtotime($created_iso);
  $modified = strtotime($modified_iso);
  $created_string = human_time_diff($created, current_time('timestamp'));
  $modified_string = human_time_diff($modified, current_time('timestamp'));
  $TEN_MINUTES = 10*60;

  if ( ($modified - $created) > $TEN_MINUTES) {
    if ($or_not_and) {
      return "Modified $modified_string ago";
    }
    return "Created $created_string ago, modified $modified_string ago";
  }
  return "Created $created_string ago";
}

function created_or_modified( $created_iso, $modified_iso ) {
  return created_and_modified( $created_iso, $modified_iso, true );
}

function truncate($string,$length) {
  if ( strlen($string) <= $length ) {
    return $string;
  }
  # http://stackoverflow.com/questions/79960/how-to-truncate-a-string-in-php-to-the-word-closest-to-a-certain-number-of-chara
  return preg_replace('/\s+?(\S+)?$/', '', substr($string, 0, $length)).'...';
}

function clean_timestamp($iso_timestamp) {
  $tmp = new \DateTime($iso_timestamp);
  $date = $tmp->format("jS M Y");
  $time = $tmp->format("H:i:s");
  return "$date at $time";
}

function human_number($number, $precision = 1) {
  $prefix = "";
  if ($number<0) { 
    $prefix = "-"; 
    $number=-$number; 
  }
  if ($number==0) { 
    return "0"; 
  }
  $base = log($number, 1000);
  $suffixes = array('', 'k', 'M', 'G', 'T');   
  return $prefix.round(pow(1000, $base - floor($base)), $precision) . $suffixes[floor($base)];
}

/*
 * Render '1634' as '1.6k'
 */
function human_filesize($bytes) {
    if ($bytes >= 1073741824)
    {
        $bytes = number_format($bytes / 1073741824, 1) . ' GB';
    }
    elseif ($bytes >= 1048576)
    {
        $bytes = number_format($bytes / 1048576, 1) . ' MB';
    }
    elseif ($bytes >= 1024)
    {
        $bytes = number_format($bytes / 1024, 1) . ' KB';
    }
    elseif ($bytes > 1)
    {
        $bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1)
    {
        $bytes = $bytes . ' byte';
    }
    else
    {
        $bytes = '0 bytes';
    }

    return $bytes;
}

/* 
 * Echo a trailing 's' on the end of a word if it's a plural.
 * Will do for now, but requires work for translation. 
 */
function plural($number) {
  if ($number!==1) { echo "s"; }
}
