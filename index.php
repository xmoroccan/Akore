<?php

/**
 * Akore PHP Framework
 * @package   Akore
 * @author    Mohamed Elbahja <Mohamed@elbahja.me>
 * @copyright 2016 Dinital Production 
 * @version   1.1
 * @link http://www.dinital.com
 */

/**
 * Developer Mode
 */
define('DEV_MODE', true);

/**
 * Directory Separator
 */
define('DS', DIRECTORY_SEPARATOR);

/**
 * Root Directory
 */
define('ROOT', __DIR__);

/**
 * Akore Directory
 */
define('AKORE_DIR', ROOT . DS . 'Akore');

/**
 * App Directory
 */
define('APP_DIR', ROOT . DS . 'App');

/**
 * Require Init file
 */
require_once(AKORE_DIR . DS . 'Init.inc.php');