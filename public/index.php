<?php

use Jc\Http\HttpNotFoundException;
use Jc\Http\Request;
use Jc\Http\Response;
use Jc\Routing\Router;
use Jc\Server\PhpNativeServer;

require_once "../vendor/autoload.php";

$router = new Router();

$router->get('/test/{param}', function (Request $request) {
    return Response::json($request->routeParameters());
});

$router->post('/test', function (Request $request) {
    return Response::json($request->data());
});

$router->get('/redirect', function (Request $request) {
    return Response::redirect("/test");
});

$server = new PhpNativeServer();
try {
    $request = $server->getRequest();
    $route = $router->resolve($request);
    $request->setRoute($route);
    $action = $route->action();
    $response = $action($request);
    $server->sendResponse($response);
} catch (HttpNotFoundException $e) {
    $response = Response::text("Not found")->setStatus(404);
    $server->sendResponse($response);
}