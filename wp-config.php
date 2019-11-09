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
define( 'DB_NAME', 'PGPI_DB' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         '-uvr*2nuGD4qJ}9jB.Ik1p~PpU3rM=zD|Jbjj#;corOsaom,K#n #*{o:fw`Or1t' );
define( 'SECURE_AUTH_KEY',  '9?`Rh0)e4}fe6{@[Q:r1=#-PX)T_,r:DBnjTq#x1b5z8c<*A8_Z,x6}nAbKEdlNr' );
define( 'LOGGED_IN_KEY',    ')m3^<;6G@XfC<gRux~Ga&QIJDc/;)%%C=ocl/A;7H?5CO%hVS2?eG]kx*:6A%|#%' );
define( 'NONCE_KEY',        'm97<q>2o) W4o+!e}!B:~_iX)!jF~x;0<3N,dG&7*X6LraC3!Nc0qxv8J:mFnp~/' );
define( 'AUTH_SALT',        'f?-;*0#}_oI7,s(~T6+vX.?gMvyBMEBIN!AfY1Wq#@EOjc{cyS}X@|9N$A[5>vv>' );
define( 'SECURE_AUTH_SALT', 'oJ{/{ >?4U~g0-kyH*pz*][!:`c*o%g:9~~Wnj$Ke8t}Wug;;o}/dq`I =B,_NM`' );
define( 'LOGGED_IN_SALT',   'Y^EWkTPQ%n[>oe`~qF5&rXl)J8^VsNf:(^48}$X>B>0<$j9yocr}R R19z>/2Yd`' );
define( 'NONCE_SALT',       'j4-dK1rj>#/ l`wx,4c.g+;--}r,c^*5S:)6<~aJfI Iwz^Rvzq_bit5~40E=bi$' );

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
