<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Tuupola\Middleware\CorsMiddleware;


require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '../service.php';


$app = AppFactory::create();

// Add CORS middleware
$corsMiddleware = new CorsMiddleware([
    "origin" => ["*"],
    "methods" => ["GET", "POST", "PUT", "DELETE", "PATCH", "OPTIONS"],
    "headers.allow" => ["Content-Type", "Authorization"],
    "headers.expose" => [],
    "credentials" => true,
    "cache" => 0,
]);

$app->options('/{routes:.+}', function (Request $request, Response $response) {
    return $response;
});

$app->add($corsMiddleware);

//write code here
// $routesHelper = new Routes();
$app->post('/register_user', function (Request $request, Response $response) {
    $service = new Service();
    $res = $service->handler_register($request, $response);
    return $response;
});

$app->post('/create_group', function (Request $request, Response $response) {
    $service = new Service();
    $res = $service->handler_create_group($request,$response);
    return $response;
});

$app->post('/join_group', function (Request $request, Response $response) {
    $service = new Service();
    $res = $service->handler_join_group($request,$response);
    return $response;
});


$app->post('/post_message', function (Request $request, Response $response) {
    $service = new Service();
    $res = $service->handler_post_message($request,$response);
    return $response;
});


$app->get('/get_message', function (Request $request, Response $response) {
    $service = new Service();
    $res = $service->handler_get_message($request,$response);
    return $response;
});

$app->run();
