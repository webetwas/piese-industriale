<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/**
 * [DATABASE NAME - required]
 * @var [type]
 */ define("DATABASE_NAME", "pieseind_db");
define("MAIN_APP", "WEWZERODAY");
define("MAIN_APP_VER", "1.3");
define("CORE_APP", "CI");
define("CORE_APP_VER", "3.1.5");

/**
 * CONSTANTS
 *
 */
// define("BASE_URL", "http://recukinetic.dev/admin");
// define("SITE_URL", "http://recukinetic.dev/");

// define("BASE_URL", 'http://' .$_SERVER['HTTP_HOST']. '/admin/');
define("BASE_URL", 'http://' .$_SERVER['HTTP_HOST']. '/2019/piese-industriale/admin/');
// define("SITE_URL", 'http://' .$_SERVER['HTTP_HOST']. '/');
define("SITE_URL", 'http://' .$_SERVER['HTTP_HOST']. '/2019/piese-industriale/web/');

define("TBL_OWNER", "be_owner");
define("TBL_COMPANY", "be_ocompany");
define("TBL_USERS", "be_users");
define("TBL_PAGES", "fe_pages");
define("TBL_PAGES_STRUCTURE", "fe_pages_structure");
define("TBL_PAGES_BANNERS", "fe_pages_banners");
define("TBL_PAGES_IMAGES", "fe_pages_images");
define("TBL_CHAIN_LINKS", "chain_links");
define("TBL_POROTOFOLIU_PROIECTE", "portofoliu_proiecte");
define("TBL_POROTOFOLIU_PROIECTE_IMAGES", "portofoliu_proiecte_images");
define("TBL_PORTOFOLIU_PROIECTE_SIMILAR", "portofoliu_proiecte_similar");
define("TBL_AIRS", 'airs');

define("TBL_OBJ_OBJECTS", "obj_objects");
define("TBL_OBJ_CONTENT", "obj_content");

define("TBL_USERA_ABOUT", "be_users_about");

define("MAP_CAL_DAYS", "core_calendar_days");
define("MAP_CAL_MONTHS", "core_calendar_months");
//
// Low CONSTANTS
define("SET_COMPANIE", "companie");
define("SET_UTILIZATOR", "utilizator");
define("PUT", "put");
define("GET", "get");
define("ITEM", "item");
//
define("INSERT", "i");
define("UPDATE", "u");
define("DELETE", "d");
define("UPLOADIMG", "upimg");
define("UPIMGBANNER", "banner");
define("UPIMGPOZA", "poza");
define("UPIMGLOGO", "logo");
define("BANNERFDATA", "bannerformdata");
define("PRODUCT_STATE", "toggle_product_state");

define("CHANGEPASSWORD", "cp");

define("IMG_SIZE_CULORI_S", json_encode(array("w" => 25, "h" => 17, "p" => false)));
define("IMG_SIZE_CULORI_M", json_encode(array("w" => 200, "h" => null, "p" => true)));
define("IMG_SIZE_CULORI_L", json_encode(array("w" => 419, "h" => 504, "p" => false)));

// File
// Images

define("IMG_SIZE_S", json_encode(array("w" => 100, "h" => 75, "p" => false)));
define("IMG_SIZE_M", json_encode(array("w" => 300, "h" => 225, "p" => false)));
define("IMG_SIZE_L", json_encode(array("w" => 1024, "h" => 768, "p" => false)));

define("IMG_SIZE_BANNER1", json_encode(array("width" => 937, "height" => 192, "proportion" => false)));
define("IMG_SIZE_BANNER2", json_encode(array("width" => 1180, "height" => 150, "proportion" => false)));
define("IMG_SIZE_BANNER3", json_encode(array("width" => 1180, "height" => 150, "proportion" => false)));
define("IMG_SIZE_BANNER4", json_encode(array("width" => 1180, "height" => 150, "proportion" => false)));

define("IMG_LOGO_W", 196);
define("IMG_LOGO_H", 83);
define("IMG_LOGO_P", true);

// Misc
define("PATH_IMG_MISC", "public/upload/img/misc/");
define("PATH_IMG_PAGINA", "public/upload/img/page/page/");
define("PATH_IMG_BANNERS", "public/upload/img/page/banners/");
define("PATH_IMG_CATALOG_PRODUSE", "public/upload/img/catalog_produse/");
define("PATH_IMG_NODES", "public/upload/img/nodes/");

define("PATH_IMG_ECHIPA", "public/upload/img/echipa/");
define("PATH_IMG_BRANDURI", "public/upload/img/branduri/");


// Portofoliu
define("TBL_PORTOFOLIU_PROIECTE", "portofoliu_proiecte");

// AJAX CATEGORIES
define("LINKREQUEST", "linkrequest");
define("AJXELEMENTMOVED", "ajxmoveelement");
define("AJXTOGGLE", "ajaxtoggle");

define('AIRDROP_CONTROLLER', 'airdrop/');

define("TBL_UTILIZATORI", "shop_utilizatori");
define("TBL_CLIENTI", "shop_clienti");
define("TBL_COMENZI", "shop_comenzi");