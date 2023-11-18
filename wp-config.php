<?php
define( 'WP_CACHE', true ); // Added by WP Rocket

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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'marinaio_test' );

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
define( 'AUTH_KEY',         'dO5^{A(PHHTi)mYWG.07]l8> &0sInF7l8%jXtWG4T43W(0,O45vIP$chUz-^zVp' );
define( 'SECURE_AUTH_KEY',  'LWu{3i65Vmkyq|q127~E(Fm~rnlZ+J[[3}e1sRB*-kXQO)C{+%5;tnRTc|,Np=X ' );
define( 'LOGGED_IN_KEY',    'i9[9EpCuOYYZfQzYvfa0{i}+d$d/w+LZ+~qXV3[q(F3<XB.OUY%;:**!_RCd(jlm' );
define( 'NONCE_KEY',        '5+2GbfYW?h)WVqIc_QNPNBZT&c~):hN(g.ER6AR*EL,74D4KEA&oFq1pTX024fh|' );
define( 'AUTH_SALT',        'Lk$_yBrkXsc-brSOrT);Gk<r![ceuy6%P;E{f/8~}nFQYO{qt?8>B6 QP&R)joq5' );
define( 'SECURE_AUTH_SALT', 'GnPAz:$Uk=QF2uXfV/?u3@KB!6-J8#B;##.A*#9WpRr;~[6&6[5Uk}*Q5O[{*bQO' );
define( 'LOGGED_IN_SALT',   '@/u kbdYv[D&9&KMh^EGJN`9DKCK~vnVS]S u!X9pM9{oI kpAL@ZCI~]HVs+Xnh' );
define( 'NONCE_SALT',       'GWngdf{{DNHvTgARcQDxr(Z8RwwV:neMTD6=3B2Unt!O^/hRY?Ci)$R=Uj]Bt-Sy' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */
ini_set( 'upload_max_filesize' , '128M' );
ini_set( 'post_max_size', '128M');
ini_set( 'memory_limit', '256M' );
ini_set( 'max_execution_time', '300' );
ini_set( 'max_input_time', '300' );


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
