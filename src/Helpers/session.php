<?php


use Jc\Session\Session;

function session(): Session {
    return app()->session;
}