<?
/**
 * Modify the string on the login page to prompt for username or email address
 */
function patch_nav_is_register() {
  return array_key_exists('action', $_REQUEST) && $_REQUEST['action']==='register';
}

function patch_nav() {
	if ( 'wp-login.php' != basename( $_SERVER['SCRIPT_NAME'] ) )
		return;

	?><script type="text/javascript">
  function _patch_nav_li(title, url, active) {
    var out = document.createElement('li');
    out.innerHTML = '<a href="'+url+'">'+title+'</a>';
    if (active) {
      out.setAttribute('class', 'active');
    }
    return out;
  }
	// Form
  var newNav = document.createElement('ul');
  newNav.setAttribute('id', 'new-nav');
  newNav.appendChild(_patch_nav_li('<?= __("Log In") ?>', '/wp-login.php', <?= ! patch_nav_is_register() ? 'true':'false'?>));
  newNav.appendChild(_patch_nav_li('<?= __("Sign Up") ?>', '/wp-login.php?action=register', <?=  patch_nav_is_register() ? 'true':'false' ?>));
  var h1 = document.getElementsByTagName('h1');
  if (h1.length) {
    var div = document.createElement('div');
    div.appendChild(newNav);
    div.setAttribute('id','new-nav-container');
    h1[0].parentNode.insertBefore(div, h1[0].nextSibling);
  }
	</script><?
}
add_action( 'login_footer', 'patch_nav' );
