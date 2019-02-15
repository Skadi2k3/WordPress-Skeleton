<?php

// ===================================================
// Load environment variables using PHP Dotenv
// ===================================================
require __DIR__ . '/vendor/autoload.php';
try {
	$dotenv = Dotenv\Dotenv::create(__DIR__);
	$dotenv->load();
} catch (\Exception $e) {
}

// ===================================================
// Load local development parameters
// ===================================================
if ( getenv('SYS_ENV') === 'local' ) {
	define( 'WP_LOCAL_DEV', true );

	if ( file_exists( dirname( __FILE__ ) . '/local-config.php' ) ) {
		include( dirname( __FILE__ ) . '/local-config.php' );
	}
} else {
	define( 'WP_LOCAL_DEV', false );
}

// ===================================================
// Load debug settings
// ===================================================
if ( getenv('SYS_DEBUG') ) {
	// =================================================================
	// Debug mode
	// Debugging? Enable these. Can also enable them in local-config.php
	// =================================================================

	// ===========
	// Show errors
	// ===========
	ini_set( 'display_errors', 1 );
	define( 'WP_DEBUG_DISPLAY', true );

	// define( 'SAVEQUERIES', true );
	define( 'WP_DEBUG', true );
} else {
	// ===========
	// Hide errors
	// ===========
	ini_set( 'display_errors', 0 );
	define( 'WP_DEBUG_DISPLAY', false );
}

// ===================================================
// Load database info
// ===================================================
define( 'DB_NAME', 			getenv( 'DB_NAME' ) );
define( 'DB_USER', 			getenv( 'DB_USER' ) );
define( 'DB_PASSWORD', 	getenv( 'DB_PASSWORD' ) );
define( 'DB_HOST', 			getenv( 'DB_HOST' ) );

// ========================
// Custom Content Directory
// ========================
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/content' );
define( 'WP_CONTENT_URL', ( getenv( 'SYS_SSL' ) ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . '/content' );

// ================================================
// You almost certainly do not want to change these
// ================================================
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

// ==============================================================
// Salts, for security
// Grab these from: https://api.wordpress.org/secret-key/1.1/salt
// ==============================================================
define( 'AUTH_KEY',         getenv( 'SYS_AUTH_KEY' ) );
define( 'SECURE_AUTH_KEY',  getenv( 'SYS_SECURE_AUTH_KEY' ) );
define( 'LOGGED_IN_KEY',    getenv( 'SYS_LOGGED_IN_KEY' ) );
define( 'NONCE_KEY',        getenv( 'SYS_NONCE_KEY' ) );
define( 'AUTH_SALT',        getenv( 'SYS_AUTH_SALT' ) );
define( 'SECURE_AUTH_SALT', getenv( 'SYS_SECURE_AUTH_SALT' ) );
define( 'LOGGED_IN_SALT',   getenv( 'SYS_LOGGED_IN_SALT' ) );
define( 'NONCE_SALT',       getenv( 'SYS_NONCE_SALT' ) );

// ==============================================================
// Table prefix
// Change this if you have multiple installs in the same database
// ==============================================================
$table_prefix  = 'wp_';

// ================================
// Language
// Leave blank for American English
// Change to de_DE for German (Germany)
// ================================
define( 'WPLANG', '' );

// =========================================
// Hide the page where you can edit styling
// and markup etc. under the Appearance menu
// =========================================
define( 'DISALLOW_FILE_EDIT', true );

// ================================
// prevent user update/installation
// of plugins and themes
// ================================
define( 'DISALLOW_FILE_MODS', false );

// ===============
// only allow https for admin area
// ===============
define( 'FORCE_SSL_ADMIN', false );

// ======================================
// Load a Memcached config if we have one
// ======================================
if ( file_exists( dirname( __FILE__ ) . '/memcached.php' ) )
	$memcached_servers = include( dirname( __FILE__ ) . '/memcached.php' );

// ===========================================================================================
// This can be used to programatically set the stage when deploying (e.g. production, staging)
// ===========================================================================================
define( 'WP_STAGE', '%%WP_STAGE%%' );
define( 'STAGING_DOMAIN', '%%WP_STAGING_DOMAIN%%' ); // Does magic in WP Stack to handle staging domain rewriting

// ===================
// Bootstrap WordPress
// ===================
if ( !defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/wp/' );
require_once( ABSPATH . 'wp-settings.php' );
