<?
/**
 * Modify the string on the login page to prompt for username or email address
 */
function lostpassword_form() {
	if ( 'wp-login.php' != basename( $_SERVER['SCRIPT_NAME'] ) )
		return;

	?><script type="text/javascript">
	// Form
  var form = document.getElementById('lostpasswordform');
  if (form) {
    form.setAttribute('action', '/wp-login.php?action=lostpassword');
  }
  var form2 = document.getElementById('resetpassform');
  if (form2) {
    form2.setAttribute('action', '/wp-login.php?action=resetpass');
  }
	</script><?
}
add_action( 'login_footer', 'lostpassword_form' );
