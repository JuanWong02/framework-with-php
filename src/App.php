<?php

namespace Jc;

use Jc\Database\Drivers\DatabaseDriver;
use Jc\Database\Drivers\PdoDriver;
use Jc\Database\Model;
use Jc\Http\HttpMethod;
use Jc\Http\HttpNotFoundException;
use Jc\Http\Request;
use Jc\Http\Response;
use Jc\Routing\Router;
use Jc\Server\PhpNativeServer;
use Jc\Server\Server;
use Jc\Session\PhpNativeSessionStorage;
use Jc\Session\Session;
use Jc\Validation\Exceptions\ValidationException;
use Jc\Validation\Rule;
use Jc\View\JcEngine;
use Jc\View\View;
use Throwable;

class App {
    public Router $router;

    public Request $request;

    public Server $server;

    public View $view;

    public Session $session;

    public DatabaseDriver $database;

    public static function bootstrap() {
        $app = singleton(self::class);
        $app->router = new Router();
        $app->server = new PhpNativeServer();
        $app->request = $app->server->getRequest();
        $app->view = new JcEngine(__DIR__ . "/../views");
        $app->session = new Session(new PhpNativeSessionStorage());
        $app->database = new PdoDriver();
        $app->database->connect('mysql', 'localhost', 3306, 'curso_framework', 'root', '');
        Model::setDatabaseDriver($app->database);
        Rule::loadDefaultRules();

        return $app;
    }

    public function prepareNextRequest() {
        if ($this->request->method() == HttpMethod::GET) {
            $this->session->set('_previous', $this->request->uri());
        }
    }

    public function terminate(Response $response) {
        $this->prepareNextRequest();
        $this->server->sendResponse($response);
        $this->database->close();
        exit();
    }

    public function run() {
        try {
            $this->terminate($this->router->resolve($this->request));
        } catch (HttpNotFoundException $e) {
            $this->abort(Response::text("Not found")->setStatus(404));
        } catch (ValidationException $e) {
            $this->abort(back()->withErrors($e->errors(), 422));
        } catch (Throwable $e) {
            $response = json([
                "error" => $e::class,
                "message" => $e->getMessage(),
                "trace" => $e->getTrace()
            ]);

            $this->abort($response->setStatus(500));
        }
    }

    public function abort(Response $response) {
        $this->terminate($response);
    }
}