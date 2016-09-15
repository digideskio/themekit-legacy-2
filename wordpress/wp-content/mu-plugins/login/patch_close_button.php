<?
/**
 * Modify the string on the login page to prompt for username or email address
 */
function patch_close_button() {
	if ( 'wp-login.php' != basename( $_SERVER['SCRIPT_NAME'] ) )
		return;

	?><script type="text/javascript">
	// Form Label
  function _getBackToBlogText() {
    var backToBlog = document.getElementById('backtoblog');
    if (backToBlog) {
      return backToBlog.children[0].innerHTML;
    }
    return null;
  }
  var closeButton = document.createElement('a');
  closeButton.setAttribute('href', '/');
  if (_getBackToBlogText()) {
    closeButton.setAttribute('title', _getBackToBlogText());
  }
  closeButton.setAttribute('id', 'close-button');
  closeButton.innerHTML = '×';
  document.getElementById('login').appendChild(closeButton);
	</script><?php
}
add_action( 'login_footer', 'patch_close_button' );
