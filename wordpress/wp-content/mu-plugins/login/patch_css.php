<?
function dp_login_css() {
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".plugin_dir_url(__FILE__)."/global-login.css\"></link>";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".get_stylesheet_directory_uri()."/login.css\"></link>";
}
add_action('login_head', 'dp_login_css');
