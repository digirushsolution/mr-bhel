<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'halfprice-new' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         '6 -~dIBz~ko4|ESg=cuw3umD.u&=2f_d:S$FXi?&:Fia]zMfj)_b6fw1ooKP%qo2' );
define( 'SECURE_AUTH_KEY',  'C_YDO~9mTZ=+N9PbOHF$oAt`#Z29Z_&L<#:lWi.^tpx$q1[8Hz~{brNr|*4%vX.#' );
define( 'LOGGED_IN_KEY',    'Y)vNl-!%uN]HP;i.Rl7Z&[!QW}oB`}y<B5U1Zh EdDK:@@i;rPdrJ9Yq#Ud:v+%z' );
define( 'NONCE_KEY',        'ErM,~3i_MMpkuIm++K(CJ_#qwNT2q<h>V`unbwPcl<M[2[Nd#@rerfe6,m!LYb:a' );
define( 'AUTH_SALT',        'MHHI/7Sksx$u+QK5~HM[:^qcfg-Srqc;Ld9`jGa#|&[,!CvnYz3@KI9~%tdsj{iU' );
define( 'SECURE_AUTH_SALT', '2WP|gHQ_oZY,YmHBGfH;ge{tU6<Qh53hkc~(8[c4Uk3h0NwW|i&~e@@UZ;>Hu&),' );
define( 'LOGGED_IN_SALT',   '=q3;,_jKsnS!NvgLaX:WJ9Q^yUe04x/JY/OYj{!drG9UGgVJ,}H+WEF5Ax5h6[iE' );
define( 'NONCE_SALT',       '0cNUFqg6*O|;iu _;%!>{BV~(VdEnJ1Wss|u8Km><ee+^CH1e+UWaMQ~r,Pjp,EN' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
