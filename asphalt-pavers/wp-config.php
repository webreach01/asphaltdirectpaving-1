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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'asphaltd_wp' );

/** MySQL database username */
define( 'DB_USER', 'asphaltd_wp' );

/** MySQL database password */
define( 'DB_PASSWORD', 'AcIxQ8HPuWDe' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'qeD=r4k,oZAY5V%*Eo8f-`V3PG%%XD-w;BaQYCN~[<53fh0s|%[`QLd4RRq$v3+B');
define('SECURE_AUTH_KEY',  '6yx|]C#Z$zYNIDI$g/A_im?my/n8CyXXkXhPi=2Uv Go`i^}+f|LUyFD9@D;DX3^');
define('LOGGED_IN_KEY',    'q0XeSk]YN{88Y_C%+*Asl%=By ]`3-wi./(Fla+yV-?MZpF ;9hI5{3$`j~{L5@}');
define('NONCE_KEY',        '20HeIE|L;U%_v25;PR0JufDD))AoGjB3@:7$]K|}.A)NOLmy#;kqUcRdZM$Y92>k');
define('AUTH_SALT',        '/Nt4ZE52jV8-[-$cN#< 3Ob-3Sd[P6R1v%f3QyY|tUz1c_8+U!.nR[wb)||B7@~|');
define('SECURE_AUTH_SALT', 'R^.ldaM+$$-eWZpb)]K*p2lf|X; #8q]bl:|#a3S4gk*INm/ml!%Q;1i|Exp7xKA');
define('LOGGED_IN_SALT',   'c)T;l(^~i6lkP{$bxq-tyr^M$;U218]P?Nn/|MP3 v^sj>(bh<*hAhQuY`fIDuT ');
define('NONCE_SALT',       'Dq7<Ve:XjH+g ~ZIJN6;{*3%/b?<b|~q-_SUxH*76P1p3v4wKpMn;ROW*p9|)U1L');


/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
