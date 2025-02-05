<?php
// ** MySQL settings ** //
/** The name of the database for WordPress */
define('DB_NAME', 'tugboat');
define('DB_USER', 'tugboat');
define('DB_PASSWORD', 'tugboat');
define('DB_HOST', 'mysql');

// Set our Tugboat hostname.
define( 'WP_HOME', 'https://' . getenv('TUGBOAT_SERVICE_URL_HOST') );

// Define the location where WordPress Core is installed.
// In this case, a subdirectory of the webroot called "wp".
define( 'WP_SITEURL', 'https://' . getenv('TUGBOAT_SERVICE_URL_HOST') . '/' );

/** For developers: WordPress debugging mode. */
define('WP_DEBUG', false);