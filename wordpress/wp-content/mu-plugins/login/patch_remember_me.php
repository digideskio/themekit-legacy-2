<?
/**
 * Modify the string on the login page to prompt for username or email address
 */
function patch_rememberme() {
	if ( 'wp-login.php' != basename( $_SERVER['SCRIPT_NAME'] ) )
		return;

	?><script type="text/javascript">
	// Form
  var input = document.getElementById('rememberme');
  if (input) {
    input.setAttribute('checked', 'checked');
  }
	</script><?
}
add_action( 'login_footer', 'patch_rememberme' );
