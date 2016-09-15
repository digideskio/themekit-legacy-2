<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'themekit');

/** MySQL database username */
define('DB_USER', 'themekit');

/** MySQL database password */
define('DB_PASSWORD', 'themekit');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ' uhFBHkFLpeh>_+6XWuw|i-{GgGKbl<+G)*,Td}VcZjrt<4m&Q&fFZGrVR|%(Q{h');
define('SECURE_AUTH_KEY',  'U2AA]yi&ih(TqLw7HDOEe~~<AeE,~P~,Z3@-wk(>(KVT|g(>5i+nD{08S.F(5)9{');
define('LOGGED_IN_KEY',    'R:4N&G(9+){1/-v,3TO7kd/jB-vc[H@.JfL|9K!V&p|cz[{(/~d7#GWfRGm62z5E');
define('NONCE_KEY',        'fC2g+fT6GRv&?h(DNGm4F7YCRegc},/^A0[?Mn-).$QYt8;;I6=ujxg&7^$Y.PSL');
define('AUTH_SALT',        '|P cI9BXrI/zfxsBs2rZEz@1}k$~7xk!uDu7I/s-7fF=nsLHq>oER!|/Gg.MSD5j');
define('SECURE_AUTH_SALT', '5j.d5JW2%4!qnZcFS;s#&`Uin?]NsSY;n[h.}53j:30wg+,H+_6ze(?~JnpNq(`*');
define('LOGGED_IN_SALT',   'Jwb4eMp2lvtlgm;bv|cnK7tBHK=&%0C)5cU/0mn$f=4i,L7y`7&ne#@T0T-11t3>');
define('NONCE_SALT',       'uOXieNNE#F}tD41!Fbs}-@@DLP-h:7Tx5;rFT`%U<,Us*?=>7sh6jI kp([M-pP ');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
