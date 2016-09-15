<?
/* 
 * Render a PHP array as HTML attributes. Eg:
 * Input:       array('foo'=>1, 'bar'=>'baz)
 * Returns:     data-foo="1" data-bar="baz"
 */
function parameters_as_html($parameters) {
  $out = '';
  foreach ($parameters as $key=>$value) {
    if (is_array($value)) {
      $value = json_encode($value);
      $value = htmlspecialchars($value);
      $out .= " data-$key=\"$value\"";
    }
    else {
      $out .= " data-$key=\"$value\"";
    }
  }
  return $out;
}

function render_activity_stream($activities) {
  foreach ($activities as $activity) {
    ?>
    <li class="item <?= array_key_exists('activity type', $activity) ? strtolower($activity['activity type']) : ''; ?>">
      <? if (isset($activity['is_new']) && $activity['is_new']): ?>
        <span class="new" title="New activity item">New activity item</span>
      <? endif; ?>
      <i class="fa fa-<?= _activity_icon($activity); ?>"></i>
      <p>
        <? echo _activity_message($activity); ?>
        <span class="date"><?= human_time_diff(strtotime($activity['timestamp']), current_time('timestamp')); ?> ago</span>
      </p>
    </li>
  <?
  }
}


function _activity_icon($activity) {
  $activity_type = $activity['activity_type'];
  if ($activity_type=='added tag')             { return 'tag'; }
  if ($activity_type=='changed group')         { return 'group'; }
  if ($activity_type=='changed package')       { return 'sitemap'; }
  if ($activity_type=='changed package_extra') { return 'edit'; }
  if ($activity_type=='changed resource')      { return 'file'; }
  if ($activity_type=='changed user')          { return 'user'; }
  if ($activity_type=='deleted group')         { return 'group'; }
  if ($activity_type=='deleted package')       { return 'sitemap'; }
  if ($activity_type=='deleted package_extra') { return 'edit'; }
  if ($activity_type=='deleted resource')      { return 'file'; }
  if ($activity_type=='new group')             { return 'group'; }
  if ($activity_type=='new package')           { return 'sitemap'; }
  if ($activity_type=='new package_extra')     { return 'edit'; }
  if ($activity_type=='new resource')          { return 'file'; }
  if ($activity_type=='new user')              { return 'user'; }
  if ($activity_type=='removed tag')           { return 'tag'; }
  if ($activity_type=='deleted related item')  { return 'picture'; }
  if ($activity_type=='follow dataset')        { return 'sitemap'; }
  if ($activity_type=='follow user')           { return 'user'; }
  if ($activity_type=='follow group')          { return 'group'; }
  if ($activity_type=='new related item')      { return 'picture'; }
  if ($activity_type=='changed organization')  { return 'briefcase'; }
  if ($activity_type=='deleted organization')  { return 'briefcase'; }
  if ($activity_type=='new organization')      { return 'briefcase'; }
  return 'certificate'; // This is when no activity icon can be found
}

function _activity_resource_name($resource) {
  if ( ! empty($resource['name']) ) {
    return $resource['name'];
  }
  if ( ! empty($resource['description']) ) {
    $description = $resource['description'];
    $description = explode('.',$description);
    $description = $description[0];
    if ( ! empty($description) ) {
      return $description;
    }
  }
  return "Unnamed resource";
}


function _activity_message($activity) {
  // -- Core links and strings
  if ( array_key_exists('user_name', $activity)) {
    $__actor_link          = site_url("/user/{$activity['user_name']}");
    $__actor_truncated     = truncate($activity['user_display_name'],60);
    
    $_actor        = "<span class=\"actor\"><a href=\"$__actor_link\">$__actor_truncated</a></span>";
  }

  if( array_key_exists('package', $activity['data'])) {
    $__dataset_link        = site_url("/dataset/{$activity['data']['package']['name']}");
    $__dataset_truncated   = truncate($activity['data']['package']['title'], 180);
    
    $_dataset      = "<span><a href=\"$__dataset_link\">$__dataset_truncated</a>";
    if(array_key_exists('resource', $activity['data'])) {
      $__resource_link       = site_url("/dataset/{$activity['data']['package']['name']}/resource{$activity['data']['resource']['id']}");
      $__resource_truncated  = truncate( _activity_resource_name($activity['data']['resource']), 180 );
      
      $_resource     = "<span><a href=\"$__resource_link\">$__resource_truncated</a>";
    }
  }

  if( array_key_exists('group', $activity['data'])) {
    $__group_link          = site_url("/topic/{$activity['data']['group']['name']}");
    $__group_truncated     = truncate($activity['data']['group']['title'], 180);
    $__publisher_link      = site_url("/publisher/{$activity['data']['group']['name']}");
    $__publisher_truncated = truncate($activity['data']['group']['title'], 180);

    $_group        = "<span><a href=\"$__group_link\">$__group_truncated</a>";
    $_organization = "<span><a href=\"$__publisher_link\">$__publisher_truncated</a>";
  }



  // -- HTML-marked-up entities
  $_user         = "_user"; // return literal('''<span>%s</span>''' % (h.linked_user(activity['object_id'], 0, 20)))
  $_tag          = array_key_exists('tag', $activity['data']) ? $activity['data']['tag'] : '';
  $_extra        = array_key_exists('package_extra', $activity['data']) ? "\"".$activity['data']['package_extra']['key']."\"" : '';
  $_related_item = "(deprecated: related items)";
  $_related_type = "(deprecated: related items)";

  // -- Full return strings
  $activity_type = $activity['activity_type'];
  if ($activity_type=='added tag')             { return "$_actor added the tag $_tag to the dataset $_dataset"; }
  if ($activity_type=='changed group')         { return "$_actor updated the group $_group"; }
  if ($activity_type=='changed organization')  { return "$_actor updated the organization $_organization"; }
  if ($activity_type=='changed package')       { return "$_actor updated the dataset $_dataset"; }
  if ($activity_type=='changed package_extra') { return "$_actor changed the extra $_extra of the dataset $_dataset"; }
  if ($activity_type=='changed resource')      { return "$_actor updated the resource $_resource in the dataset $_dataset"; }
  if ($activity_type=='changed user')          { return "$_actor updated their profile"; }
  if ($activity_type=='deleted group')         { return "$_actor deleted the group $_group"; }
  if ($activity_type=='deleted organization')  { return "$_actor deleted the organization $_organization"; }
  if ($activity_type=='deleted package')       { return "$_actor deleted the dataset $_dataset"; }
  if ($activity_type=='deleted package_extra') { return "$_actor deleted the extra $_extra from the dataset $_dataset"; }
  if ($activity_type=='deleted resource')      { return "$_actor deleted the resource $_resource from the dataset $_dataset"; }
  if ($activity_type=='new group')             { return "$_actor created the group $_group"; }
  if ($activity_type=='new organization')      { return "$_actor created the organization $_organization"; }
  if ($activity_type=='new package')           { return "$_actor created the dataset $_dataset"; }
  if ($activity_type=='new package_extra')     { return "$_actor added the extra $_extra to the dataset $_dataset"; }
  if ($activity_type=='new resource')          { return "$_actor added the resource $_resource to the dataset $_dataset"; }
  if ($activity_type=='new user')              { return "$_actor signed up"; }
  if ($activity_type=='removed tag')           { return "$_actor removed the tag $_tag from the dataset $_dataset"; }
  if ($activity_type=='deleted related')       { return "$_actor deleted the related item $_related_item"; }
  if ($activity_type=='follow dataset')        { return "$_actor started following $_dataset"; }
  if ($activity_type=='follow user')           { return "$_actor started following $_user"; }
  if ($activity_type=='follow group')          { return "$_actor started following $_group"; }
  if ($activity_type=='changed related')       { return "$_actor updated the related items of the dataset $_dataset"; }
  if ($activity_type=='new related')           { return "$_actor updated the related items of the dataset $_dataset"; }
  return "Unrecognised activity type $activity_type";
}

/* 
 * Render an AJAX "load more" button which triggers a Javascript widget when clicked.
 * Required parameters:
 *   "endpoint"  :  AJAX HTML endpoint to hit
 *   "selector"  :  CSS selector. Where should I append the returned HTML string?
 */
function render_ajax_button($parameters) {
  if ( ! isset($parameters['text']) ) {
    $parameters['text'] = "Load More";
  }
  $parameters = parameters_as_html($parameters);
  echo "<button class=\"btn btn-small btn-info dp-ajax-load-more\" data-widget=\"AjaxLoadMore\" $parameters>Load more...</button>";
}
