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
	$container['db']		   = function () {
		$pdo = new PDO('mysql:host='.DBHOST_slim.';dbname='.DBNAME_slim.';charset='.CHARSET.';connect_timeout=15', DBUSER_slim, DBPASS_slim);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		return $pdo;
	};

    require_once '../src/router.php';

	$app->run();