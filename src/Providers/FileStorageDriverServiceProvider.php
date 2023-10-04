<?php

namespace Jc\Providers;

use Jc\App;
use Jc\Storage\Drivers\DiskFileStorage;
use Jc\Storage\Drivers\FileStorageDriver;

class FileStorageDriverServiceProvider {
    public function registerServices() {
        match (config("storage.driver", "disk")) {
            "disk" => singleton(
                FileStorageDriver::class,
                fn () => new DiskFileStorage(
                    App::$root . "/storage",
                    "storage",
                    config("app.url")
                )
            ),
        };
    }
}