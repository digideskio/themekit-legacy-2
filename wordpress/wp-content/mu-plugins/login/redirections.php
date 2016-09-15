<?
function my_login_redirect( $redirect_to, $request, $user ) {
  return '/user';
}
add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );

function go_home(){
  wp_redirect( home_url() );
  exit();
}
add_action('wp_logout','go_home');
