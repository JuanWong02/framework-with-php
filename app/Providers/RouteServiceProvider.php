<?php

namespace App\Providers;

use Jc\App;
use Jc\Providers\ServiceProvider;
use Jc\Routing\Route;

class RouteServiceProvider implements ServiceProvider {
    public function registerServices()
    {
        Route::load(App::$root . "/routes");
    }
}