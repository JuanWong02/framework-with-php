<?php

use Jc\Http\HttpNotFoundException;
use Jc\Http\Request;
use Jc\Http\Response;
use Jc\Routing\Router;
use Jc\Server\PhpNativeServer;

require_once "../vendor/autoload.php";



$router = new Router();

$router->get('/test', function (Request $request) {
    return Response::text("GET OK");
});

$router->post('/test', function (Request $request) {
    return Response::text("POST OK");
});
$router->get('/redirect', function (Request $request) {
    return Response::redirect("/test");
});
$router->put('/test', function () {
    return Response::text("PUT OK");
});
$router->patch('/test', function () {
    return Response::text("PATCH OK");
});
$router->delete('/test', function () {
    return Response::text("DELETE OK");
});

$server = new PhpNativeServer();
try {
    $request = new Request($server);
    $route = $router->resolve($request);
    $action = $route->action();
    $response = $action($request);
    $server->sendResponse($response);
} catch (HttpNotFoundException $e) {
    $response = Response::text("Not Found")->setStatus("404");
    $server->sendResponse($response);
}
