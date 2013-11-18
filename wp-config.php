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
define('DB_NAME', 'ecom_saohoa');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'ltt123');

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
define('AUTH_KEY',         'y!V)Kn0[b&ju/R&^*93nLQ64d2JtZOz7U~#${)4sZ3*9=EDe^XHI#(Bi4`I)Lx6q');
define('SECURE_AUTH_KEY',  'F0qQZNg9ZZEWL?IA<QN8Whxb4cq;GWqLV{MH7ZG7MIroON/S7)Uiioh;4ei/}zwk');
define('LOGGED_IN_KEY',    'k~Zvd#+S9 `|{-bO*vf.|HN71c&Y;K[~]JpUhd(ACrh}Ppn]q-hUbSV|9^_:,{/N');
define('NONCE_KEY',        '9lvx+`>xiKCK[Szm4HL(*7v*sWp2x(wt+qpy>wNN5,AV/IW=r!.Mtes2{vrzSj.-');
define('AUTH_SALT',        '=djVg=eiVC^j3B+jJ%b]/Y<>0o-WxS,(ZgdTqDKf(_Srx3acrGo|^dY7X8ckbBrM');
define('SECURE_AUTH_SALT', ':0nxPQDf[@jHQ|bsiMqU<|FS*c:x2Lba;BGw`YNG5>l_-HbCid*c*BPUsiZjq-,N');
define('LOGGED_IN_SALT',   '>rDP Fb&d6W$y V@Z5uGJ+!n/sZ`IgrEo;,VudoR$#6UdRWzVzz{N78[-IlWAL=C');
define('NONCE_SALT',       '%b1b}0ba-OV6w>x/~ejz)nRRQ:~@!*V5JTl*1#9ldCr]>jIRvu8Zz%gxTCh:n* ?');

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
define('WPLANG', 'vi');

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
