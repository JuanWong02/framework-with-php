<?php

namespace Jc\Providers;

use Jc\Auth\Authenticators\Authenticator;
use Jc\Auth\Authenticators\SessionAuthenticator;

class AuthenticatorServiceProvider implements ServiceProvider {
    public function registerServices()
    {
        match (config("auth.method", "session")) {
            "session" => singleton(Authenticator::class, SessionAuthenticator::class),
        };
    }
}