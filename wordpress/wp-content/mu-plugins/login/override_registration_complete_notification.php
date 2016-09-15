<?
add_filter( 'wp_login_errors', 'datapress_registration_complete' );
function datapress_registration_complete($errors) {
	if	( isset($_GET['checkemail']) && 'registered' == $_GET['checkemail'] ) {
    $errors->remove('registered');
		$errors->add('registered', __('<span style="float:left;width:100%;padding:12px;margin:-12px;background-color:#5CB85C;color:#fff;">&#10004 Registration complete. Please check your email.</span>'), 'message');
  }
	elseif	( isset($_GET['checkemail']) && 'confirm' == $_GET['checkemail'] ) {
    $errors->remove('confirm');
		$errors->add('confirm', __('<span style="float:left;width:100%;padding:12px;margin:-12px;margin-bottom:12px;background-color:#5CB85C;color:#fff;">&#10004 Check your email for the confirmation link.</span>'), 'message');
  }
  return $errors;
}
add_action('login_footer', 'hide_login_form_after_registration');
function hide_login_form_after_registration() {
	if	( isset($_GET['checkemail']) && 'registered' == $_GET['checkemail'] ) {
    ?><script type="text/javascript">
        if ( document.getElementById('loginform') ) {
          Array.from(document.getElementById('loginform').getElementsByTagName('p')).forEach( function(p) {
          if( !(p.className === 'submit') )
            p.style.display = 'none';
          });
          document.getElementById('new-forgot-password-link').style.display = 'none';
          document.getElementsByClassName('message')[0].style.marginTop = '24px';
          document.getElementsByClassName('submit')[0].style.marginTop = '-6px';
        }
      </script><?
  }
}
