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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'Basededatostienda' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '(#%yw)D|%x~9,>3kdkECZ#a;Qr<Wf73MHElsD4``%fF^DgT43>FgNvH82dD io4K' );
define( 'SECURE_AUTH_KEY',  '!@%c{F@_GO,Bv=HYDY&DDN v4Zp<Y;:g=-`vKND]IdhZ__x_FTDI%Z0MND,qaw3J' );
define( 'LOGGED_IN_KEY',    'T&8-%Y`}rBPHh/Lfmn3%lyk:pKof0kz@^7+imgU~fp2&6t0o;]j8+0|[nOh-^Wf@' );
define( 'NONCE_KEY',        '(K^s+gNz;}mmjI:H2YWj+y;/OxM=YP3c5>= FtZ1sV`^reTQ5PfSd$Bk4!{eQbp(' );
define( 'AUTH_SALT',        'XNm0NAdhcubYe:x#x|bTl}]pKC(w1>fkc.e$PUCT*$w(exJRvD$5U{Pn|LO*.UAB' );
define( 'SECURE_AUTH_SALT', 'wg$|wn$|>W*GF;s4][sD:M<=WvV_5E_8?]OAF%59H[E(W-{}pEMbR!d4bB`Zs 1F' );
define( 'LOGGED_IN_SALT',   '1?=u@nAV=QeQ^`ng?i59o0opIg8w,4w-/ jJ3.l7z9-k:S)Zc1C.d``na$$(!ii?' );
define( 'NONCE_SALT',       '{0b]cBWLew~930RxmaUf%4h(44lFv1)Di/eB)&cG]E{.ct+I<~#|[|FwiQ7PVKxt' );

/**#@-*/

/**
 * WordPress database table prefix.
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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
