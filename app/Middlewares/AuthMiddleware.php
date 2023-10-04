<?php

namespace App\Middlewares;

use Closure;
use Jc\Auth\Auth;
use Jc\Http\Middleware;
use Jc\Http\Request;
use Jc\Http\Response;

class AuthMiddleware implements Middleware{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::isGuest()) {
            return redirect('/login');
        }

        return $next($request);
    }
}