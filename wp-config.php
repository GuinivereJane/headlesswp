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
//a chang
require_once(__DIR__ . '/vendor/autoload.php');
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

// define('ENVIRONMENT_DEV', 'dev');
// define('ENVIRONMENT_STAGE', 'stage');
// define('ENVIRONMENT_PROD', 'prod');
// define('ENVIRONMENT', getenv('ENVIRONMENT'));


define('JWT_AUTH_SECRET_KEY', getenv('JSONTOKEN_SECERET') );
define('JWT_AUTH_CORS_ENABLE', true);

// /** no errors on production **/
// if (ENVIRONMENT === ENVIRONMENT_PROD) {
//     error_reporting(0);
//     @ini_set('display_errors', 0);
// }
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', getenv('DB_NAME') );

/** MySQL database username */
define( 'DB_USER', getenv('DB_USER') );

/** MySQL database password */
define( 'DB_PASSWORD', getenv('DB_PASSWORD') );

/** MySQL hostname */
define( 'DB_HOST', getenv('DB_HOST') );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define('AUTH_KEY', '2cc607c5708a005272925837f0dc00e6d762255d759730f77ab9956a7e3b7b3e');
define('SECURE_AUTH_KEY', '618a6d87e4695d8d64a95d200b2e013445a9b3c4e353cdac1eec7f5d5ad1ea83');
define('LOGGED_IN_KEY', '68d8e752027839b8ece0106382b6c065559956656dc07b5751f7dbd6587c7735');
define('NONCE_KEY', '78977e46695fc85897dbca03804f3257b97576ed840767f4700786cfcc8dd529');
define('AUTH_SALT', '0dcc6c81f3b18caad187b80ad72d32eb61ccf1da1f0a6eda0446cb719491d291');
define('SECURE_AUTH_SALT', '7d69446f2b3de63685ce4faf8ad4d2285e20bffa3a00c63d8e19092cc4b745d0');
define('LOGGED_IN_SALT', '274df4769b9a2cf967f3073127986045c3ebf52fd5e0601914ae7f21ef71647c');
define('NONCE_SALT', 'bcc348832804a66db32c600ebf5ceeebbf8ef994b10fd8c919c27924595f3fb9');

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

define('FS_METHOD', 'direct');

/**
 * The WP_SITEURL and WP_HOME options are configured to access from any hostname or IP address.
 * If you want to access only from an specific domain, you can modify them. For example:
 *  define('WP_HOME','http://example.com');
 *  define('WP_SITEURL','http://example.com');
 *
*/

if ( defined( 'WP_CLI' ) ) {
    $_SERVER['HTTP_HOST'] = 'localhost';
}

define('WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] . '/');
define('WP_HOME', 'http://' . $_SERVER['HTTP_HOST'] . '/');


/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );

define('WP_TEMP_DIR', '/opt/bitnami/apps/wordpress/tmp');


//  Disable pingback.ping xmlrpc method to prevent Wordpress from participating in DDoS attacks
//  More info at: https://docs.bitnami.com/general/apps/wordpress/troubleshooting/xmlrpc-and-pingback/

if ( !defined( 'WP_CLI' ) ) {
    // remove x-pingback HTTP header
    add_filter('wp_headers', function($headers) {
        unset($headers['X-Pingback']);
        return $headers;
    });
    // disable pingbacks
    add_filter( 'xmlrpc_methods', function( $methods ) {
            unset( $methods['pingback.ping'] );
            return $methods;
    });
    add_filter( 'auto_update_translation', '__return_false' );
}
