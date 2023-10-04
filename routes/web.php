<?php

use App\Controllers\ContactController;
use App\Controllers\HomeController;
use Jc\Auth\Auth;
use Jc\Routing\Route;

Auth::routes();

Route::get('/',fn () => redirect('/home'));
Route::get('/home', [HomeController::class, 'show']);

Route::get('/contacts', [ContactController::class, 'index']);
Route::get('/contacts/create', [ContactController::class, 'create']);
Route::post('/contacts', [ContactController::class, 'store']);

