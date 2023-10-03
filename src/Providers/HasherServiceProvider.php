<?php

namespace Jc\Providers;

use Jc\Crypto\Bcrypt;
use Jc\Crypto\Hasher;

class HasherServiceProvider implements ServiceProvider {
    public function registerServices()
    {
        match (config("hashing.haher", "bcrypt")) {
            "bcrypt" => singleton(Hasher::class, Bcrypt::class),
        };
    }
}