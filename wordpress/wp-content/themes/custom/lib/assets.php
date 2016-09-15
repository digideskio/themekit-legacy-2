<?php
namespace Roots\Sage\Assets;

/*
 * Return the path to an asset stored in theme base or in the child theme.
 * Files can be overridden or overwritten by creating identical paths in the child theme.
 */
function asset_path($path) {

  if ( file_exists(get_stylesheet_directory() . '/' . $path) ) {
    return get_stylesheet_directory_uri() . '/' . $path;
  }

  return get_template_directory_uri() . '/' . $path;
}


function assets() {
  // This magically injects fallbacks for CDN-hosted properties
  add_filter('script_loader_src', __NAMESPACE__ . '\\inject_fallback', 10, 2);

  wp_enqueue_style('sage_css', asset_path('dist/styles/main.css'), false, null);

  wp_enqueue_style('select2_css',  "//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css", false, null);

  wp_enqueue_style( 'dashicons' );

  if (!is_admin()) {
    wp_deregister_script('jquery');

    wp_enqueue_script('jquery', "//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.1/jquery.min.js", [], null, false);
  }
  // TODO Remove this to go live. useful for bootswatching and bootswatching only
  wp_enqueue_script('bootswatch_custom', "http://bootswatch.com/assets/js/custom.js", [], null, true);

  wp_enqueue_script('modernizr', "//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.min.js", [], null, true);

  wp_enqueue_script('jquery_cookie', "https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js", [], null, true);

  wp_enqueue_script('select2', "//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js", [], null, true);

  wp_enqueue_script('moment', "//cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js", [], null, true);

  wp_enqueue_script('bootstrap', asset_path('lib/bootstrap-sass/assets/javascripts/bootstrap.min.js'), [], null, true);
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);


// Based upon code in http://wordpress.stackexchange.com/a/12450
function inject_fallback($src, $handle = null) {
  /* 
   * This function is passed through several times, every time a new script is included.
   * At the moment of execution, the system is _about_ to echo the CDN <script> tag to the page.
   * We have to wait until the next pass to echo the fallback code.
   */
  static $output_on_next_pass = false;
  if ($output_on_next_pass) {
    echo $output_on_next_pass;
  }
  $output_on_next_pass = get_fallback($handle);
  // Perform no actual filtering.
  return $src;
}

function get_fallback($handle) {
  switch ($handle) {
    case 'jquery':
      return '<script>window.jQuery || document.write(\'<script src="' . asset_path('lib/jquery/dist/jquery.min.js') .'"><\/script>\')</script>' . "\n";
    // case 'jquery_cookie':
    //   return '<script>window.jQuery.prototype.cookie || document.write(\'<script src="' . asset_path('lib/jquery-cookie/jquery.cookie.js') .'"><\/script>\')</script>' . "\n";
    case 'modernizr':
      return '<script>window.Modernizr || document.write(\'<script src="' . asset_path('lib/modernizr/modernizr.js') .'"><\/script>\')</script>' . "\n";
    case 'moment':
      return '<script>window.moment || document.write(\'<script src="' . asset_path('lib/moment/min/moment.min.js') .'"><\/script>\')</script>' . "\n";
    case 'select2':
      $js_src  = asset_path('lib/select2/dist/js/select2.min.js');
      $css_src = asset_path('lib/select2/dist/css/select2.min.css');
      return "<script>window.jQuery.prototype.select2 || document.write('<script src=\"$js_src\"><\/script><link rel=\"stylesheet\" href=\"$css_src\"><\/link>');</script>\n";
    default:
      return false;
  }
}

