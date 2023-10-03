<?php
namespace Jc\Providers;

use Jc\Server\PhpNativeServer;
use Jc\Server\Server;

class ServerServiceProvider implements ServiceProvider {
    public function registerServices() {
        singleton(Server::class, PhpNativeServer::class);
    }
}