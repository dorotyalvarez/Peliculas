<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle($request, Closure $next)
{
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403); // o redirect()->route('login')
    }
    return $next($request);
}
}