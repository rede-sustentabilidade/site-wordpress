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

// Disable filesystem level changes from WP
define('DISALLOW_FILE_EDIT',true);
define('DISALLOW_FILE_MODS',true);

// Try environment variable 'WP_ENV'
if (getenv('WP_ENV') !== false) {
    // Filter non-alphabetical characters for security
    define('WP_ENV', preg_replace('/[^a-z]/', '', getenv('WP_ENV')));
}
// Define site host
if (isset($_SERVER['HTTP_X_FORWARDED_HOST']) && !empty($_SERVER['HTTP_X_FORWARDED_HOST'])) {
    $hostname = $_SERVER['HTTP_X_FORWARDED_HOST'];
} else {
    $hostname = $_SERVER['HTTP_HOST'];
}
// If WordPress has been bootstrapped via WP-CLI detect environment from --env=<environment> argument
if (PHP_SAPI == "cli" && defined('WP_CLI_ROOT')) {
    foreach ($argv as $arg) {
        if (preg_match('/--env=(.+)/', $arg, $m)) {
            define('WP_ENV', $m[1]);
        }
    }
}

// Try server hostname
if (!defined('WP_ENV')) {
    // Set environment based on hostname
    switch ($hostname) {
      case 'redesustentabilidade.org.br':
      case 'www.redesustentabilidade.org.br':
        define('WP_ENV', 'production');
  		define('WP_CACHE', true);
		define('WP_API_PATH', 'https://api-v1.redesustentabilidade.org.br/');
		define('WP_PASSPORT_PATH',       'https://passaporte.redesustentabilidade.org.br');
		define('OAUTH_REDIRECT_URI',     'https://redesustentabilidade.org.br/');
		define('OAUTH_CLIENT_ID',        getenv('OAUTH_CLIENT_ID'));
		define('OAUTH_CLIENT_SECRET',    getenv('OAUTH_CLIENT_SECRET'));
		define('OAUTH_URL_AUTHORIZE',    'https://passaporte.redesustentabilidade.org.br/oauth/authorization');
		define('OAUTH_URL_ACCESS_TOKEN', 'https://passaporte.redesustentabilidade.org.br/oauth/token');
		define('OAUTH_URL_RESOURCE',     'https://passaporte.redesustentabilidade.org.br/oauth/resource');
        break;

      case 'redesustentabilidade.net':
      case 'www.redesustentabilidade.net':
        define('WP_ENV', 'staging');
  		define('WP_CACHE', false);
		define('WP_API_PATH', 'http://api-v1.redesustentabilidade.net');
		define('WP_PASSPORT_PATH',       'http://passaporte.redesustentabilidade.net');
		define('OAUTH_REDIRECT_URI',     'http://redesustentabilidade.net/');
		define('OAUTH_CLIENT_ID',        'XnvqtV7U');
		define('OAUTH_CLIENT_SECRET',    '00UlvMJicqoY8y3qtFoY');
		define('OAUTH_URL_AUTHORIZE',    'http://passaporte.redesustentabilidade.net/oauth/authorization');
		define('OAUTH_URL_ACCESS_TOKEN', 'http://passaporte.redesustentabilidade.net/oauth/token');
		define('OAUTH_URL_RESOURCE',     'http://passaporte.redesustentabilidade.net/oauth/resource');
        break;
      case 'rede.site':
      default:
        define('WP_ENV', 'development');
		define('WP_CACHE', false);
		define('WP_API_PATH',            'http://rede.api:9000');
		define('WP_PASSPORT_PATH',       'http://rede.passaporte:3000');
		define('OAUTH_REDIRECT_URI',     'http://rede.site/');
		define('OAUTH_CLIENT_ID',        'LiwFKQ0b');
		define('OAUTH_CLIENT_SECRET',    'vEdVSdklM6Y1Vo5HFWkz');
		define('OAUTH_URL_AUTHORIZE',    'http://rede.passaporte:3000/oauth/authorization');
		define('OAUTH_URL_ACCESS_TOKEN', 'http://rede.passaporte:3000/oauth/token');
		define('OAUTH_URL_RESOURCE',     'http://rede.passaporte:3000/oauth/resource');
	}
}

// Are we in SSL mode?
if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ||
    (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')) {
    $protocol = 'https://';
} else {
    $protocol = 'http://';
}
// Define WordPress Site URLs if not already set in config files
if (!defined('WP_SITEURL')) {
    define('WP_SITEURL', $protocol . rtrim($hostname, '/'));
}
if (!defined('WP_HOME')) {
    define('WP_HOME', $protocol . rtrim($hostname, '/'));
}
// Clean up
unset($hostname, $protocol);

// Set SSL'ed domain
if ( !empty( $_ENV["SSL_DOMAIN"] ) ) {
  define( 'FORCE_SSL_LOGIN', true );
  define( 'FORCE_SSL_ADMIN', true );
}

// HTTPS port is always 80 because SSL is terminated at Heroku router / CloudFlare
define( 'JETPACK_SIGNATURE__HTTPS_PORT', 80 );

/**#@+
 * Memcache settings.
 */
if ( !empty( $_ENV["MEMCACHIER_SERVERS"] ) ) {
  $_mcsettings = parse_url($_ENV["MEMCACHIER_SERVERS"]);

  $sasl_memcached_config = array(
    'default' => array(
      array(
        'host' => $_mcsettings["host"],
        'port' => $_mcsettings["port"],
        'user' => $_ENV["MEMCACHIER_USERNAME"],
        'pass' => $_ENV["MEMCACHIER_PASSWORD"],
      ),
    ),
  );

  unset($_mcsettings);
}

/**#@-*/

/**#@+
 * MySQL settings.
 *
 * We are getting Heroku ClearDB settings from Heroku Environment Vars
 */
if ( isset( $_ENV["DATABASE_URL"] ) ) {
  $_dbsettings = parse_url($_ENV["DATABASE_URL"]);
} else {
  $_dbsettings = parse_url("mysql://herokuwp:password@127.0.0.1/herokuwp");
}

define('DB_NAME',     trim($_dbsettings["path"],"/"));
define('DB_USER',     $_dbsettings["user"]          );
define('DB_PASSWORD', $_dbsettings["pass"]          );
define('DB_HOST',     $_dbsettings["host"]          );
define('DB_CHARSET',  'utf8'                        );
define('DB_COLLATE',  'utf8_unicode_ci'             );

unset($_dbsettings);

// Set SSL settings
if ( isset( $_ENV["CLEARDB_SSL"] ) && 'ON' == $_ENV["CLEARDB_SSL"] ) {
  define('MYSQL_CLIENT_FLAGS', MYSQLI_CLIENT_COMPRESS | MYSQLI_CLIENT_SSL);
  define('MYSQL_SSL_KEY',      $_ENV["CLEARDB_SSL_KEY"]                  );
  define('MYSQL_SSL_CERT',     $_ENV["CLEARDB_SSL_CERT"]                 );
  define('MYSQL_SSL_CA',       $_ENV["CLEARDB_SSL_CA"]                   );
} else {
  define('MYSQL_CLIENT_FLAGS', MYSQLI_CLIENT_COMPRESS                    );
}

/**#@-*/

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
$_saltKeys = array(
  'AUTH_KEY',
  'SECURE_AUTH_KEY',
  'LOGGED_IN_KEY',
  'NONCE_KEY',
  'AUTH_SALT',
  'SECURE_AUTH_SALT',
  'LOGGED_IN_SALT',
  'NONCE_SALT',
);

foreach ( $_saltKeys as $_saltKey ) {
  if ( !defined( $_saltKey ) ) {
    define(
      $_saltKey,
      empty( $_ENV[ $_saltKey ] ) ? 'herokuwp' : $_ENV[ $_saltKey ]
    );
  }
}

unset( $_saltKeys, $_saltKey );

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
define('WPLANG', 'pt_BR');

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

require(ABSPATH . "../vendor/autoload.php");
define( 'DB_CONFIG_FILE', ABSPATH . 'db-config.php' );
/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
