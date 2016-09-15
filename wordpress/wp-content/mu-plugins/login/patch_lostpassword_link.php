<?
/**
 * Modify the string on the login page to prompt for username or email address
 */
function patch_lostpassword_link() {
	if ( 'wp-login.php' != basename( $_SERVER['SCRIPT_NAME'] ) )
		return;
  ?>
  <div id="new-forgot-password-link">
    <a href="/wp-login.php?action=lostpassword">
      <?= __("Don't remember your password?") ?>
    </a>
  </div><?
}
add_action( 'login_form', 'patch_lostpassword_link' );
