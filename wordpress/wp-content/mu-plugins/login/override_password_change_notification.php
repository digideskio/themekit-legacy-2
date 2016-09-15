<?
/**
 * Disable the "Password lost/changed" notification
 */
if ( !function_exists( 'wp_password_change_notification' ) ) {
  function wp_password_change_notification() {}
}
