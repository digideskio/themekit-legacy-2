<?
// From http://justintadlock.com/archives/2009/05/09/using-shortcodes-to-show-members-only-content
function visitor_check_shortcode( $atts, $content = null ) {
	 if ( ( !is_user_logged_in() && !is_null( $content ) ) || is_feed() )
		return $content;
	return '';
}
add_shortcode( 'visitor', 'visitor_check_shortcode' );
