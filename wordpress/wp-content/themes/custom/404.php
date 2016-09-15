<?
global $flash_messages;
function error_icon() {
  $http_code = http_response_code();
  if ($http_code==404)  { return "icon-warning-sign"; }
  if ($http_code==403)  { return "icon-unlock-alt"; }
  if ($http_code==401)  { return "icon-unlock-alt"; }
  if (is_404())         { return "icon-warning-sign"; }
  return "icon-spinner";
}
function error_text() {
  $http_code = http_response_code();
  if ($http_code==404)  { return __('404 Not Found', 'sage'); }
  if ($http_code==403)  { return __('403 Forbidden', 'sage'); }
  if ($http_code==401)  { return __('401 Please Log In', 'sage'); }
  return __('Catalogue Unavailable', 'sage');
}
?>
  <main>

    <?
    if ( empty($flash_messages) && is_404()) {
      echo "<div class=\"alert alert-danger\">";
      echo __('Sorry, but the page you were trying to view does not exist.', 'sage');
      echo "</div>";
    }
    ?>
    <div style="
      text-align: center;
      color: #e0e0e0;
    ">
      <i style="font-size: 15em; vertical-align: middle;" class="<? echo error_icon(); ?>"></i>
    </div>

  </main>
