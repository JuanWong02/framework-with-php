<?php

namespace Jc\Auth;

use Jc\Auth\Authenticators\Authenticator;

class Auth {
    public static function user(): ?Authenticatable {
        return app(Authenticator::class)->resolve();
    }

    public static function isGuest(): bool {
        return is_null(self::user());
    }
}