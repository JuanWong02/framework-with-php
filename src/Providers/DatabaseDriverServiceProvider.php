<?php
namespace Jc\Providers;

use Jc\Database\Drivers\DatabaseDriver;
use Jc\Database\Drivers\PdoDriver;
use Jc\Server\PhpNativeServer;
use Jc\Session\PhpNativeSessionStorage;
use Jc\Session\SessionStorage;

class DatabaseDriverServiceProvider implements ServiceProvider {
    public function registerServices() {
        match (config("database.connection", "mysql")) {
            "mysql", "pgsql" => singleton(DatabaseDriver::class, PdoDriver::class),
        };
    }
}