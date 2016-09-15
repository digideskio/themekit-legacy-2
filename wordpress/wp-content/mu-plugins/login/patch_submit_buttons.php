<?
/**
 * Modify the string on the login page to prompt for username or email address
 */
function patch_submit_buttons() {
	if ( 'wp-login.php' != basename( $_SERVER['SCRIPT_NAME'] ) )
		return;

	?><script type="text/javascript">
	// Form Label
  var x = document.getElementById('wp-submit');
	if (x) {
    var text = x.getAttribute('value');
		x.setAttribute('value', text + ' »');
  }
  </script><?
}
add_action( 'login_footer', 'patch_submit_buttons' );
