<?php
/*
 Plugin Name: DataPress Must Use
 Description: Installed by default on all DataPress deployments
 Version: 1.0.0
 Author: DataPress Team
 Author URI: http://datapress.com
 Text Domain: datapress
 */

load_muplugin_textdomain( 'datapress' );

require('debug/debug.php');
if (DEBUG) {
  require('debug/echo.php');
}

// Disable wp_mail
//
function wp_mail() {
  return true;
}

require('login/override_registration_complete_notification.php');
require('login/override_wp_new_user_notification.php');
require('login/override_retrieve_password.php');
require('login/override_password_change_notification.php');
require('login/enable_login_with_email.php');
require('login/redirections.php');
require('login/patch_css.php');
require('login/patch_username_field.php');
require('login/patch_lostpassword_link.php');
require('login/patch_lostpassword_form.php');
require('login/patch_remember_me.php');
require('login/patch_submit_buttons.php');
require('login/patch_h1.php');
require('login/patch_close_button.php');
require('login/patch_nav.php');
require('login/patch_login_shake.php');
require('login/patch_resetpass_form.php');

require('admin/disable_update_notifications.php');

require('etc/patch_responsive_images.php');
require('etc/patch_ml_slider.php');

require('helpers/activity.php');
require('helpers/body.php');
require('helpers/facets.php');
require('helpers/nav.php');
require('helpers/querystring.php');
require('helpers/render.php');
require('helpers/search.php');
require('helpers/sidebar.php');
require('helpers/strings.php');

require('fixture/fixture.php');
