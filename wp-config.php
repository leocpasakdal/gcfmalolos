<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'gcf');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '5B-JWrN Vt:p:LuxIJ6naWOx(W|R2ObclN0X5c`_lqwzi=+^Ng~([$=YgHE,M}ih');
define('SECURE_AUTH_KEY',  '*jhl]m5tj|MvCJIA6jKxic1?87gU4W3|pDS$[+7v2n9ji(>Q4Y_N+Ejf]]^glBy/');
define('LOGGED_IN_KEY',    'o[,RC#>h0hLf{C$$K6FxwIr|./j7,T?t52:x^1f#euNQ<xg+aJ(Y]YuwG5+{#gov');
define('NONCE_KEY',        'Q:pD5h7vQ:v-NT!EKUP}AD>3A6/ -E/+*Dwg1T8w]:!HwCAv^)%|@Wh)+]2#HHHO');
define('AUTH_SALT',        '~]B h*f%^0)mf7q;s$5]~94w~NG3njoXJ/H~]89|@8[kN~jTIB:*> +jhp%y62bh');
define('SECURE_AUTH_SALT', '.G:Xv.aR]VrEf[{s{Z<SD@US8 |:zoE`I1]2;{5kq`kg$Q8m:T.tPo~<>0a),iUD');
define('LOGGED_IN_SALT',   'e rJ3[l-bAU_~H(!N6?pYtPUB?V,GNSaX),^*%+,ARgr];||q&:=Tn#xh7M}g/$t');
define('NONCE_SALT',       '[t.Jbk6q*f06YNj2+A0;|N9u}+U3vf(8MN/5AzYV/j?ul)tzS&I<is#BNw/_eep ');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
