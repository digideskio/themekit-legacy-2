<?
function wpb_remove_loginshake() {
  remove_action('login_head', 'wp_shake_js', 12);
}
add_action('login_head', 'wpb_remove_loginshake');
