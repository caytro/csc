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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'vipl1338_cerclesolidaritecommune' );

/** MySQL database username */
define( 'DB_USER', 'vipl1338_cerclesolidaritecommune' );

/** MySQL database password */
define( 'DB_PASSWORD', 'BTPresident2022' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         ' }SKO4_XlJAay(2Xpu(qfVMXKc>)t[}PH^B,-%`~ $y/IJ* *e)kks)W#gM80Ep+' );
define( 'SECURE_AUTH_KEY',  'O7XGfSK=26dG[~xu?.q]5[88jiopFecEDcQaggFyG4GyPxkK#_/)yUm*-mX[X?uX' );
define( 'LOGGED_IN_KEY',    '_0+OdTXFhuNg=?B9/uU01PhsOn@UB*;tubK1#wrdFfG>_1z_,)e{nyL[ibiD+5:+' );
define( 'NONCE_KEY',        '&t~Por<@GGH{ Iyv2BqszO3RNQa%UoMl>f|_)<R[$}f}fa_0[,n~a^CqD)k%/scx' );
define( 'AUTH_SALT',        'F/J.{UWCkU}${:4zoM]_/q7};_7J>sq3c..CF@K/y/_O}UI$umGt$_-3w#-=h:?q' );
define( 'SECURE_AUTH_SALT', '}=,3eBZqXH/uq>&z%A-vH`YqRr)OMij]-=>Vb|(7WPfO(r1w@#/rV#eyz7sB)7p0' );
define( 'LOGGED_IN_SALT',   'U~l8szN%D4v0}0Q4l-XX/P<g89d!M}ql]Vq8_NNsD/H__=THw*}Bi=CC_lvQ9 #7' );
define( 'NONCE_SALT',       'Y2+CN 1c{15u1sa<-vmw4<HK(5V9Z3R7y=rX#b/]3g:Iw~5)inwSSh$|<}C*G*3g' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
