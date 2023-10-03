<?php

use Jc\Auth\Auth;
use Jc\Auth\Authenticatable;

function auth(): ?Authenticatable {
    return Auth::user();
}

function isGuest(): bool {
    return Auth::isGuest();
}