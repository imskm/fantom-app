<?php

/**
 * ------------------------------------------------------------------
 * Custom routes for the application
 * ------------------------------------------------------------------
 *
 * This page has user specif routes
 */



/**
 * ------------------------------------------------------------------
 * The default routes
 * ------------------------------------------------------------------
 * This are the default reoutes to get you started
 *
 * @Note: Don't suffix the word "Controller" in controller name
 *  as done below in ["controller" => "Home"]
 */
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('auth/{controller}', ['action' => 'index', 'namespace' => 'Auth']);
$router->add('auth/{controller}/{action}', ['namespace' => 'Auth']);

$router->add('user', [
	'controller' 	=> 'Home',
	'action' 		=> 'index',
	'namespace' 	=> 'User'
]);
$router->add('user/{controller}', ['action' => 'index', 'namespace' => 'User']);
$router->add('user/{controller}/{action}', ['namespace' => 'User']);
$router->add('user/{controller}/{id:\d+}/{action}', ['namespace' => 'User']);

$router->add('admin', [
	'controller' 	=> 'Home',
	'action' 		=> 'index',
	'namespace' 	=> 'Admin'
]);
$router->add('admin/{controller}', ['action' => 'index', 'namespace' => 'Admin']);
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);
$router->add('admin/{controller}/{id:\d+}/{action}', ['namespace' => 'Admin']);

$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');