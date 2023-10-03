<?php

return [
    'boot' => [
        \Jc\Providers\ServerServiceProvider::class,
        \Jc\Providers\DatabaseDriverServiceProvider::class,
        \Jc\Providers\SessionStorageServiceProvider::class,
        \Jc\Providers\ViewServiceProvider::class,
        \Jc\Providers\AuthenticatorServiceProvider::class,
    ],
    'runtime' => [
        App\Providers\RuleServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
    ]
];