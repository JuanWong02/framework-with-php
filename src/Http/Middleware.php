<?php 

namespace Jc\Http;

use Closure;

interface Middleware {
    public function handle(Request $request, Closure $next): Response;
}