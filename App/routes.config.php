<?php defined('ROOT') || exit;

/**
 * Akore PHP Framework
 * @package   Akore
 * @author    Mohamed Elbahja <Mohamed@elbahja.me>
 * @copyright 2016 Dinital Production 
 * @version   1.1
 * @link http://www.dinital.com
 * @license http://opensource.org/licenses/MIT  MIT License
 */

$route = array();

// route[request] = array(Methods, 'include_file', params limit)

$route['/'] = array('GET', 'index', 0);

$route['test'] = array('GET', 'test', 1);

$route['user'] = array(['GET', 'POST'], array('/' => 'index', 
	'login'    => 'userlogin',
	'register' => 'userRegister'), 1);