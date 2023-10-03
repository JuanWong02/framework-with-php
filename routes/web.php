<?php

use Jc\Http\Response;
use Jc\Routing\Route;

Route::get('/', fn ($request) => Response::text("Jc Framework"));
Route::get('/form', fn ($request) => view("form"));
