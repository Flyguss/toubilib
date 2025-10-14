<?php

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use toubilib\api\middlewares\Cors;

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ );
$dotenv->load();

$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/settings.php' );
$c=$builder->build();
$app = AppFactory::createFromContainer($c);

$app->add(new Cors());

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware($c->get('displayErrorDetails'), false, false)
    ->getDefaultErrorHandler()
    ->forceContentType('application/json') ;


$app = (require_once __DIR__ . '/../src/api/routes.php')($app);


return $app;