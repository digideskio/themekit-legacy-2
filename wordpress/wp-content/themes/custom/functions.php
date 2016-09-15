<?php
// Required. Do not edit.
require_once('lib/init.php');

// --- Custom theme code past this line ---
define("DP_PRODUCTION", get_option("siteurl")=="http://your.site.url");

// Needed for article-list.php
function get_the_post_thumbnail_src($img) {
  return (preg_match('~\bsrc="([^"]++)"~', $img, $matches)) ? $matches[1] : '';
}
function get_the_post_thumbnail_width($img) {
  return (preg_match('~\bwidth="([^"]++)"~', $img, $matches)) ? $matches[1] : '';
}
function get_the_post_thumbnail_height($img) {
  return (preg_match('~\bheight="([^"]++)"~', $img, $matches)) ? $matches[1] : '';
}

function is_site_administrator() {
  if ( ! is_user_logged_in() ) {
    return false;
  }
  $user = wp_get_current_user();
  return in_array("administrator", $user->roles);
}

// --- Don't show admin bar
if ( !is_admin() ) {
  // Don't show the WP bar
  add_filter( 'show_admin_bar', '__return_false' );
}
function custom_excerpt_more() {
  return ' &hellip; <a class="read-more-link" href="' . get_permalink() . '">' . __('Read&nbsp;More&nbsp;&raquo;', 'sage') . '</a>';
}
add_filter('excerpt_more', 'custom_excerpt_more');

