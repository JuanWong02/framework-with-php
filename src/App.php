<?php

namespace Jc;

use Dotenv\Dotenv;
use Jc\Config\Config;
use Jc\Database\Drivers\DatabaseDriver;
use Jc\Database\Model;
use Jc\Http\HttpMethod;
use Jc\Http\HttpNotFoundException;
use Jc\Http\Request;
use Jc\Http\Response;
use Jc\Routing\Router;
use Jc\Server\Server;
use Jc\Session\Session;
use Jc\Session\SessionStorage;
use Jc\Validation\Exceptions\ValidationException;
use Throwable;

class App
{
    public static string $root;

    public Router $router;

    public Request $request;

    public Server $server;

    public Session $session;

    public DatabaseDriver $database;

    public static function bootstrap(string $root)
    {
        self::$root = $root;


        $app = singleton(self::class);

        return $app
            ->loadConfig()
            ->runServiceProviders('boot')
            ->setHttpHandlers()
            ->setUpDatabaseConnection()
            ->runServiceProviders('runtime');

        return $app;
    }

    protected function loadConfig(): self
    {
        Dotenv::createImmutable(self::$root)->load();
        Config::load(self::$root . "/config");

        return $this;
    }

    protected function runServiceProviders(string $type): self
    {
        foreach (config("providers.$type", []) as $provider) {
            $provider = new $provider();
            $provider->registerServices();
        }

        return $this;
    }

    protected function setHttpHandlers(): self
    {
        $this->router = singleton(Router::class);
        $this->server = app(Server::class);
        $this->request = $this->server->getRequest();
        $this->session = singleton(Session::class, fn () => new Session(app(SessionStorage::class)));

        return $this;
    }

    protected function setUpDatabaseConnection(): self
    {
        $this->database = app(DatabaseDriver::class);

        $this->database->connect(
            config("database.connection"),
            config("database.host"),
            config("database.port"),
            config("database.database"),
            config("database.username"),
            config("database.password"),
        );
        Model::setDatabaseDriver($this->database);

        return $this;
    }

    public function prepareNextRequest()
    {
        if ($this->request->method() == HttpMethod::GET) {
            $this->session->set('_previous', $this->request->uri());
        }
    }

    public function terminate(Response $response)
    {
        $this->prepareNextRequest();
        $this->server->sendResponse($response);
        $this->database->close();
        exit();
    }

    public function run()
    {
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

    public function abort(Response $response)
    {
        $this->terminate($response);
    }
}
