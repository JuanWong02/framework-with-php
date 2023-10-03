<?php

namespace Jc\Providers;

use Jc\View\JcEngine;
use Jc\View\View;

class ViewServiceProvider implements ServiceProvider {
    public function registerServices() {
        match (config("view.engine", "jc")) {
            "jc" => singleton(View::class, fn () => new JcEngine(config("view.path"))),
        };
    }
}