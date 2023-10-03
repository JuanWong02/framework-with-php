<?php

namespace App\Providers;

use Jc\Providers\ServiceProvider;
use Jc\Validation\Rule;

class RuleServiceProvider implements ServiceProvider {
    public function registerServices() {
        Rule::loadDefaultRules();
    }
}