<?php

use Jc\App;
use Jc\Container\Container;

function app(string $class = App::class) {
    return Container::resolve($class);
}

function singleton(string $class, string|callable|null $build) {
    return Container::singleton($class, $build);
}