<?
/**
 * Modify the string on the login page to prompt for username or email address
 */
function patch_h1() {
	if ( 'wp-login.php' != basename( $_SERVER['SCRIPT_NAME'] ) )
		return;

	?><script type="text/javascript">
	// Form Label
  var title = document.getElementsByTagName('title');
  if (title.length) {
    title = title[0].innerHTML;
    if (title.indexOf('›') !== -1) {
      title = title.split('›');
      title = title[title.length - 1];
      var h1 = document.getElementsByTagName('h1');
      if (h1.length) {
        h1 = h1[0];
        var a = h1.children[0];
        a.setAttribute('href', '/');
        a.removeAttribute('title');
        var small = document.createElement('small');
        small.innerHTML = title.trim();
        h1.appendChild(small);
      }
    }
  }
	</script><?php
}
add_action( 'login_footer', 'patch_h1' );
