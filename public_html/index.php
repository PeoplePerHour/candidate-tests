<?php
	require_once '../vendor/autoload.php';
	require_once '../src/config.php';

	session_start();

    $app = new \Slim\App(new \Slim\Container([
        'settings' => [
            'displayErrorDetails' => true,
            'determineRouteBeforeAppMiddleware' => true,
        ]
    ]));

	$container 				   = $app->getContainer();
	$container['csrf'] 		   = function () {	return new \Slim\Csrf\Guard;		};
	$container['flash'] 	   = function () {	return new \Slim\Flash\Messages();	};
	$container['view']  	   = function () { 	return new \Slim\Views\PhpRenderer("../src/Views/"); };

    require_once '../src/router.php';

	$app->run();