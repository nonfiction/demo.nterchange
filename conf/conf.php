<?php

// Path to directory that contains the entire app
define('ROOT_DIR', realpath(__DIR__ . '/..'));

// Loads all the environment variables from ROOT_DIR/.env
Dotenv::load(ROOT_DIR);

// Set the default timezone <http://php.net/manual/en/timezones.php>
NConfig::setTimezone(getenv('TIMEZONE'));

// Legacy defines. Environment variables should be used moving forward
define('APP_NAME', 'nterchange');
define('APP_DIR', APP_NAME);
define('CACHE_DIR', realpath(ROOT_DIR . '/var'));
define('EXTERNAL_CACHE', false); // no trailing slash
define('ASSET_DIR', realpath(ROOT_DIR . '/app'));
define('DOCUMENT_ROOT', ROOT_DIR.'/public_html');
define('ENVIRONMENT', getenv('ENVIRONMENT'));
define('SECURE_SITE', false);
define('ADMIN_SITE', APP_DIR . '/');
define('ADMIN_URL', false); // this is false by default, or the full domain of the admin (http://admin.example.com/)
define('SITE_DRAFTS', false);
define('SITE_PERMISSIONS', true);
define('SITE_WORKFLOW', false);
define('SITE_PRINTABLE', true);
define('SITE_AUDIT_TRAIL', true);
define('SITE_TIME_ZONE', 'MST7MDT'); // string id of the site's time zone (eg. MST7MDT) - this is case-sensitive!
define('ERROR_EMAIL', 'sysadmin@nonfiction.ca');
define('CURRENT_SITE', ((isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT']) == 443?'secure':'public'));
define('SITE_NAME', getenv('SITE_NAME'));

/*
0 = System is unusable
1 = Immediate action required
2 = Critical conditions
3 = Error conditions
4 = Warning conditions
5 = Normal but significant
6 = Informational
7 = Debug-level messages
*/
define('DEBUG_LEVEL', (getenv('ENVIRONMENT') == 'production') ? 0 : 7);

/*
For DEBUG_TYPE, you can add any of the following numbers together to log
multiple things at once.
For instance:
66 = 64 + 2 = SQL and Asset Debugging
127 = All debugging information

N_DEBUGTYPE_INFO  =   1 = General Info
N_DEBUGTYPE_ASSET =   2 = Asset debugging
N_DEBUGTYPE_PAGE  =   4 = Page debugging
N_DEBUGTYPE_CACHE =   8 = Cache handling
N_DEBUGTYPE_MENU  =  16 = Menu debugging
N_DEBUGTYPE_AUTH  =  32 = Auth/Login debugging
N_DEBUGTYPE_SQL   =  64 = SQL debugging
N_DEBUGTYPE_ALL   = 127 = ALL options
*/
define('DEBUG_TYPE', 127);

define('PAGE_CACHING', true);
define('TREE_CACHING', true);
// Set this to true if your navigation is actually in the body of each page.
// That way, caches are cleared when you make changes to pages to keep your site
// consistent. This should probably be set to false on a high traffic site.
define('NAV_IN_PAGE', true);

// Cache lifetime for files in seconds
define('JS_CACHE_LIFETIME', -1);

// Backend config is now loaded
require_once 'config/config.php';

// To customize which pages cannot be deleted, add their page id's here
NConfig::$protectedPages = array(1, 4);

// Set the upload handler
NUpload::connect(getenv('UPLOAD_HANDLER'));

// Sanity check for configuration
array_map(function($env){
  if (getenv($env) === false) {
    error_reporting(0);
    $error = "$env not configured!";
    echo $error;
    throw new Exception($error);
  }
}, array(
  'DB_TYPE',
  'DB_SERVER_USERNAME',
  'DB_SERVER_PASSWORD',
  'DB_SERVER',
  'DB_DATABASE'
));
