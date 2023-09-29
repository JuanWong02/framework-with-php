<?php

namespace Jc;

use Jc\Container\Container;
use Jc\Http\HttpNotFoundException;
use Jc\Http\Request;
use Jc\Http\Response;
use Jc\Routing\Router;
use Jc\Server\PhpNativeServer;
use Jc\Server\Server;
use Jc\View\JcEngine;
use Jc\View\View;

class App
{
    public Router $router;

    public Request $request;

    public Server $server;

    public View $view;

    public static function bootstrap()
    {
        $app = Container::singleton(self::class);
        $app->router = new Router();
        $app->server = new PhpNativeServer();
        $app->request = $app->server->getRequest();
        $app->view = new JcEngine(__DIR__ . "/../views");

        return $app;
    }

    public function run()
    {
        try {
            $response = $this->router->resolve($this->request);
            $this->server->sendResponse($response);
        } catch (HttpNotFoundException $e) {
            $response = Response::text("Not found")->setStatus(404);
            $this->server->sendResponse($response);
        }
    }
}
