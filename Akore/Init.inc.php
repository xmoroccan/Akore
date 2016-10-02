<?php defined('ROOT') || exit;

/**
 * Error Reporting
 */
if ( DEV_MODE === true ) {

	error_reporting(-1);
	ini_set('display_errors', 1);

} else {

	error_reporting(0);
	ini_set('display_errors', 0);
}

/**
 * Require Autoloader
 */
require_once(AKORE_DIR . DS . 'autoload.php');

/**
 * Require Config File
 */
require_once(APP_DIR . DS . 'app.config.php');

/**
 * Require Router Config file
 */
require_once(APP_DIR . DS . 'routes.config.php');

/**
 * Start App
 */
(new \Akore\Akore($route));