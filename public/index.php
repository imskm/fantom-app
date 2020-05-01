<?php
/**
 * Front Controller
 *  The Central Entry point for the site
 */

// Starting session for handling sessions
session_start();

/**
 * Directory separator
 * Diffrent platform has diffrent seprator
 * e.g. Linux use '/' and Windows '\'
 *
 * NO TRAILING SPACE IN ANY PATH CONSTANTS
 */
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", dirname(__DIR__));

const FRAMEWORK_PATH = ROOT . DS . "vendor". DS . "fantom";
const APP_PATH = ROOT . DS . "app";
const VIEW_PATH = APP_PATH . DS . "Views";
const ROUTE_FILE = APP_PATH . DS . "Routes.php";
const BOOTSTRAP_FILE = "Bootstrap.php";

/**
 * ----------------------------------------------------
 * Composer's Autoloader
 * ----------------------------------------------------
 *
 */
require ROOT . DS . "vendor" . DS . "autoload.php";

/**
 * Registering Error and Exception handler
 * and a shutdown handler : it is called when exit() is called
 * or script finishes execution
 */
error_reporting(E_ALL);
set_error_handler("Fantom\Error::errorHandler", error_reporting());
set_exception_handler("Fantom\Error::exceptionHandler");
register_shutdown_function("Fantom\Error::shutdownHandler");

/**
 * Additionaly Liabrary (vendor) bootstap file
 */
if( ! empty(BOOTSTRAP_FILE) ) {

	$_bootstrap_file_path = APP_PATH . DS . BOOTSTRAP_FILE;
	if ( is_readable($_bootstrap_file_path) ) {
		require $_bootstrap_file_path;
	}
}


/**
 * Routing
 */
$router = new Fantom\Router();

// Adding custom routes specified by user if any
if( ! empty(ROUTE_FILE) ) {

	if ( is_readable(ROUTE_FILE) ) {
		require ROUTE_FILE;
	}
}

$router->dispatch($_SERVER["QUERY_STRING"]);
