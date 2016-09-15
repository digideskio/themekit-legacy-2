<?
/**
 * Modify the string on the reset/set password page to always say 'Set Password' to avoid condusion with creating a new account
 */
function datapress_new_password() {
	if ( 'wp-login.php' != basename( $_SERVER['SCRIPT_NAME'] ) )
		return;

	?><script type="text/javascript">
	// Form Label
	if ( document.getElementById('resetpassform') )
    document.getElementById('resetpassform').childNodes[3].childNodes[1].childNodes[1].childNodes[0].nodeValue = '<?php echo esc_js( __( 'Set Password', 'datapress' ) ); ?>'; 
  </script><? 
}
add_action( 'resetpass_form', 'datapress_new_password' );
