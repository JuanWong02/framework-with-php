<?php

namespace Jc;

use Jc\Http\HttpNotFoundException;
use Jc\Http\Request;
use Jc\Http\Response;
use Jc\Routing\Router;
use Jc\Server\PhpNativeServer;
use Jc\Server\Server;
use Jc\Validation\Exceptions\ValidationException;
use Jc\View\JcEngine;
use Jc\View\View;
use Throwable;

class App {
    public Router $router;

    public Request $request;

    public Server $server;

    public View $view;

    public static function bootstrap() {
        $app = singleton(self::class);
        $app->router = new Router();
        $app->server = new PhpNativeServer();
        $app->request = $app->server->getRequest();
        $app->view = new JcEngine(__DIR__ . "/../views");

        return $app;
    }

    public function run() {
        try {
            $response = $this->router->resolve($this->request);
            $this->server->sendResponse($response);
        } catch (HttpNotFoundException $e) {
            $this->abort(Response::text("Not found")->setStatus(404));
        } catch (ValidationException $e) {
            $this->abort(json($e->errors())->setStatus(422));
        } catch (Throwable $e) {
            $response = json([
                "message" => $e->getMessage(),
                "trace" => $e->getTrace()
            ]);

            $this->abort($response);
        }
    }

    public function abort(Response $response) {
        $this->server->sendResponse($response);
    }
}