<?
function wp_new_user_notification( $user_id, $deprecated = null, $notify = '' ) {
	global $wpdb, $wp_hasher;
	$user = get_userdata( $user_id );

	// The blogname option is escaped with esc_html on the way into the database in sanitize_option
	// we want to reverse this for the plain text arena of emails.
	$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

	// $message  = sprintf(__('New user registration on your site %s:'), $blogname) . "\r\n\r\n";
	// $message .= sprintf(__('Username: %s'), $user->user_login) . "\r\n\r\n";
	// $message .= sprintf(__('Email: %s'), $user->user_email) . "\r\n";

	// @wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration'), $blogname), $message);

	// `$deprecated was pre-4.3 `$plaintext_pass`. An empty `$plaintext_pass` didn't sent a user notifcation.
	if ( 'admin' === $notify || ( empty( $deprecated ) && empty( $notify ) ) ) {
		return;
	}

	// Generate something random for a password reset key.
	$key = wp_generate_password( 20, false );

	/** This action is documented in wp-login.php */
	do_action( 'retrieve_password_key', $user->user_login, $key );

	// Now insert the key, hashed, into the DB.
	if ( empty( $wp_hasher ) ) {
		require_once ABSPATH . WPINC . '/class-phpass.php';
		$wp_hasher = new PasswordHash( 8, true );
	}
	$hashed = time() . ':' . $wp_hasher->HashPassword( $key );
	$wpdb->update( $wpdb->users, array( 'user_activation_key' => $hashed ), array( 'user_login' => $user->user_login ) );
  ob_start();
  require(dirname(__FILE__).'/../email/new_user_notification.php');
  $message = ob_get_clean();

	wp_mail($user->user_email, sprintf(__('[%s] Set up your password'), $blogname), $message);
}
