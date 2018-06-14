<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'genjo1517');

/** MySQL database username */
define('DB_USER', 'genjo1517');

/** MySQL database password */
define('DB_PASSWORD', 'r8536300@');

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
define('AUTH_KEY',         'l=;~^xd33I7k;G^yAp,4bF,L}V~e!K#<T+gdp)o:s+RF`}5[w=(f3La%~wsj9Hk+');
define('SECURE_AUTH_KEY',  '[gAk{D12GR //Vr<K%f5{lzL[v&vImT]^xR yktr@S-cAvx`e Kzq-uLlA?AwC!C');
define('LOGGED_IN_KEY',    '{((EK&}J1{V[$HzhF5X|0NACi}cuWx-f17P.Z<pe:4ofyj|5@@4 f:r]NT2+`%NL');
define('NONCE_KEY',        ')4Zu+M%81io?&xLn0t7Vqr}7+Y<B{)NL=)v|twv8AYW/#$.2nufkz|UGTBw6x_+T');
define('AUTH_SALT',        ';#0>o7nab[i?SL=?rkDC(g}f+VY($bV?:~zE75Ny$<h(2Y#yUW@XaA1WU}FVv`9&');
define('SECURE_AUTH_SALT', '*<DLM=X*B{sd~Ub$4liKJ-%NkE(6[Om_YET|H6I=(w*UtvJ@PnNLCw:1NF*5eici');
define('LOGGED_IN_SALT',   'r]y_gvOk-hg,:D~C(;3M$df$+q-k91 Qt.EBdq.Q$G5z`v5 cPCK%D,]Idnx 32,');
define('NONCE_SALT',       'T)*pEKNkeI#?>@6&?C6`zJDa`4IH379^IA~Qv<}3^,;^[a[zAm`rD=yn:vG&D0l+');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
