<?php

use Jc\Http\HttpNotFoundException;
use Jc\Http\Request;
use Jc\Http\Response;
use Jc\Routing\Router;
use Jc\Server\PhpNativeServer;

require_once "../vendor/autoload.php";



$router = new Router();

$router->get('/test', function (Request $request) {
    $response = new Response();
    $response->setHeader("Content-Type", "application/json");
    $response->setContent(json_encode(["message" => "GET OK"]));

    return $response;
});

$router->post('/test', function (Request $request) {
    return "POST OK";
});
$router->put('/test', function () {
    return "PUT OK";
});
$router->patch('/test', function () {
    return "PATCH OK";
});
$router->delete('/test', function () {
    return "DELETE OK";
});

    $server = new PhpNativeServer();
try {
    $request = new Request($server);
    $route = $router->resolve($request);
    $action = $route->action();
    $response = $action($request);
    $server->sendResponse($response);
} catch (HttpNotFoundException $e) {
    $response = new Response();
    $response->setStatus("404");
    $response->SetContent("Not Found");
    $response->setHeader("Content-Type", "text/plain");
    $server->sendResponse($response);
}
