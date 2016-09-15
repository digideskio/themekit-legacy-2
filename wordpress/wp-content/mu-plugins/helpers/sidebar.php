<?

/*
 * Render a LI link with class=active
 */
function li_link( $url, $text ) {
  $current_url = strtok($_SERVER["REQUEST_URI"],'?');
  $active = $url==$current_url ? "active dp-active" : "";
  return "<li class=\"$active\"><a href=\"$url\">$text</a></li>";
}
function admin_label() {
  return "<span class=\"label label-danger pull-right dp-admin-label\"> <i class=\"icon-cogs\"></i></span>";
}
