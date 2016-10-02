<?php 

$route = array();

$route['/'] = array('GET', 'index', 0);

$route['test'] = array('GET', 'test', 1);

$route['user'] = array(['GET', 'POST'], array('/' => 'index', 
	'login'    => 'userlogin',
	'register' => 'userRegister'), 1);