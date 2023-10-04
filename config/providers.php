<?php

return [
    /**
     * Service providers that will run before booting application
     */
    'boot' => [
        /**
         * Jc framework service providers
         */
        \Jc\Providers\ServerServiceProvider::class,
        \Jc\Providers\DatabaseDriverServiceProvider::class,
        \Jc\Providers\SessionStorageServiceProvider::class,
        \Jc\Providers\ViewServiceProvider::class,
        \Jc\Providers\AuthenticatorServiceProvider::class,
        \Jc\Providers\HasherServiceProvider::class,
        \Jc\Providers\FileStorageDriverServiceProvider::class,

        /**
         * Package service providers
         */
    ],
     /**
     * Service providers that will run after booting application
     */
    'runtime' => [
        App\Providers\RuleServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        App\Providers\AppServiceProvider::class,
    ],

    'cli' => [
        \Jc\Providers\DatabaseDriverServiceProvider::class,
    ]
];