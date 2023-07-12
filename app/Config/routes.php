<?php
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'login'));
	Router::connect('/users/thankyou', array('controller' => 'users', 'action' => 'thankyou'));
	Router::connect('/users/login', array('controller' => 'pages', 'action' => 'display', 'login'));
	Router::connect('/users/logout', array('controller' => 'users', 'action' => 'logout'));
	Router::connect('/users/myProfile', array('controller' => 'users', 'action' => 'myProfile'));
	Router::connect('/users/register', array('controller' => 'users', 'action' => 'register'));
	Router::connect('/users/registerUser', array('controller' => 'users', 'action' => 'registerUser'));
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

	CakePlugin::routes();
	require CAKE . 'Config' . DS . 'routes.php';
