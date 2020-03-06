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
define( 'DB_NAME', 'wordpress' );

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
define( 'AUTH_KEY',         'Y*ULsN]y/A6>/nc~&KUIN_NHh=Sr~?M{@~j`e_omm862Ox3MCdfmLhlH{wuqMA}+' );
define( 'SECURE_AUTH_KEY',  '#{KRf/T4C9R.+w1]~rqJU`o1-b7!Q9w_,^6iN{2=dUxbjzy(Xp;zDzT%B/*EhT?.' );
define( 'LOGGED_IN_KEY',    '`!62Cd=Jj+k0q3n>qJ{qu,Rt2~tq}G$XeNkY{4kfTLg>I@~sCW0,@2()R`p%k%+k' );
define( 'NONCE_KEY',        'gJJtN0AtF}%X|c}q!&R6pNN`V>_OXV=CJgqdd5Gr9`,^.#?L*z0 y[rO!O{C YUc' );
define( 'AUTH_SALT',        'UJO!.1bF(X163k~dt;KYGi^1IC3/%4m?30LDShkLsg|7aXf7Z(+0[(4y~8]&b{G=' );
define( 'SECURE_AUTH_SALT', 'Z]?u2^SKXr[-_3d:0$pkt OD9Kz6N_ES&OrvgK&P^U@ILecD$*DNDdnX0|qh]+oC' );
define( 'LOGGED_IN_SALT',   'Rq[ccyL_U+w*,GAH8:2[8]trJvau;Ue[S]@I[nBD^S~JUil&VBO TM$3eg?xOo8n' );
define( 'NONCE_SALT',       'j2,Y5V1bSp7aJedp,X~2APZ6~3=:X<>UagxdCfxg;eSsH@M+}:36?91`] tLqUJJ' );

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
