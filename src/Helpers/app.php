<?php

use Jc\App;
use Jc\Container\Container;

function app(string $class = App::class) {
    return Container::resolve($class);
}

function singleton(string $class) {
    return Container::singleton($class);
}