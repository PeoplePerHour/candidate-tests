<?php

use App\Handlers\TemperatureHandler;
use App\Providers\Weather\OpenWeather\OpenWeatherConfig;
use App\Providers\Weather\OpenWeather\OpenWeatherProvider;
use App\Services\WeatherService;
use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$builder = new \DI\ContainerBuilder();
$builder->useAutowiring(false);
$builder->useAnnotations(false);

$container = $builder->build();

$container->set(TemperatureHandler::class, function (ContainerInterface $container) {
    return new TemperatureHandler($container, new WeatherService(new OpenWeatherProvider()));
});

AppFactory::setContainer($container);

/**
 * Instantiate App
 *
 * In order for the factory to work you need to ensure you have installed
 * a supported PSR-7 implementation of your choice e.g.: Slim PSR-7 and a supported
 * ServerRequest creator (included with Slim PSR-7)
 */
$app = AppFactory::create();

/**
 * The routing middleware should be added earlier than the ErrorMiddleware
 * Otherwise exceptions thrown from it will not be handled by the middleware
 */
$app->addRoutingMiddleware();

/**
 * Add Error Middleware
 *
 * @param bool $displayErrorDetails -> Should be set to false in production
 * @param bool $logErrors -> Parameter is passed to the default ErrorHandler
 * @param bool $logErrorDetails -> Display error details in error log
 * @param \Psr\Log\LoggerInterface|null $logger -> Optional PSR-3 Logger
 *
 * Note: This middleware should be added last. It will not handle any exceptions/errors
 * for middleware added after it.
 */
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$jsonApi = function ($request, $response, $next) {
    $response = $next($request, $response);
    //here we can add the json api transformation
    return $response;
};

// Define app routes
$app->get('/location/{location}/unit/{unit}[/provider/{provider}]', [TemperatureHandler::class, 'getNextDay'])
    ->add($jsonApi);
//
//$container = $app->getContainer();
//
//$container->set('TemperatureHandler', function (\Psr\Container\ContainerInterface $container) {
//    return new \Handlers\TemperatureHandler();
//});

// Run app
$app->run();
