<?php
// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'tugboat' );
define( 'DB_USER', 'tugboat' );
define( 'DB_PASSWORD', 'tugboat' );
define( 'DB_HOST', 'mysql' );

// Set our Tugboat hostname.
define( 'WP_HOME', 'https://' . getenv( 'TUGBOAT_SERVICE_URL_HOST' ) );

// Define the location where WordPress Core is installed.
// In this case, a subdirectory of the webroot called "wp".
define( 'WP_SITEURL', 'https://' . getenv( 'TUGBOAT_SERVICE_URL_HOST' ) . '/' );
/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

// ** Authentication Unique Keys and Salts. ** //
define( 'AUTH_KEY', 'put your unique phrase here' );
define( 'SECURE_AUTH_KEY', 'put your unique phrase here' );
define( 'LOGGED_IN_KEY', 'put your unique phrase here' );
define( 'NONCE_KEY', 'put your unique phrase here' );
define( 'AUTH_SALT', 'put your unique phrase here' );
define( 'SECURE_AUTH_SALT', 'put your unique phrase here' );
define( 'LOGGED_IN_SALT', 'put your unique phrase here' );
define( 'NONCE_SALT', 'put your unique phrase here' );

/** WordPress Database Table prefix. */
$table_prefix = 'wp_';

/** For developers: WordPress debugging mode. */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
