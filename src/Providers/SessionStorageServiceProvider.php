<?php
namespace Jc\Providers;

use Jc\Server\PhpNativeServer;
use Jc\Session\PhpNativeSessionStorage;
use Jc\Session\SessionStorage;

class SessionStorageServiceProvider {
    public function registerServices() {
        match (config("session.storage", "native")) {
            "native" => singleton(SessionStorage::class, PhpNativeSessionStorage::class),
        };
    }
}