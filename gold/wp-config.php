<?php


/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u464433789_zpCCT' );

/** Database username */
define( 'DB_USER', 'u464433789_dCauX' );

/** Database password */
define( 'DB_PASSWORD', 'NEEaTqI9Sq' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'GyIx<7HmZcORllxFl7vv1A.yuB(7@mhfZssv%lTkqeD9K5QT&ql~MaIHU<IKu7kl' );
define( 'SECURE_AUTH_KEY',   'Ob2,VKaz5Z-.o!w5[8MT3xEWHhNI)T:tUfyjD~<w QLp4~O5ZHC!]>0agF|q>bZ*' );
define( 'LOGGED_IN_KEY',     'x4OMHm_/xsGQ &+^EPv`u`|:$ng;p)YU/@9l3;OZq!}{ox&vG#<**+j]J]5k92|?' );
define( 'NONCE_KEY',         'y!d@Ejss}_.xH^;!}z>WzP%AuA#&9,,Nnz|?sR#?pbTIM1-dQw$3(g2U##Pk<^Sn' );
define( 'AUTH_SALT',         'N=LBU)J)iuJpC{W!Mf%3?5sTLaapJ!nO3QvET.mF;NcA+e B} $9HMMPI1#=Ke >' );
define( 'SECURE_AUTH_SALT',  'W::h?<5B c>CSCbe(BxpK(V%xdoS{u`B8ARPQ8wX(1nJ@m,]f3Y6sd|T*svC]U9s' );
define( 'LOGGED_IN_SALT',    '?yJ[FMo_R=Zb8>(]F&VKdO8{@R!Pjm/ZE%?zJ7q0_u<]F=6G@JCoO&tw3a%>JWu)' );
define( 'NONCE_SALT',        'Y],@n+CmUl LfZj;&C@&S-dsCA=GI2 9e=e-p^d`nfz:]W%~rQ.or(: 7B@M~;/E' );
define( 'WP_CACHE_KEY_SALT', 'lN&xXl@Wvtq?ucadddrb;_+iAI(,`:Prj}jLVp*=a-H,(t{KWYOt#*xCIA=6TcyK' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'FS_METHOD', 'direct' );
define( 'COOKIEHASH', 'e506fb6ffaa6263dc98f9369948ec763' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
