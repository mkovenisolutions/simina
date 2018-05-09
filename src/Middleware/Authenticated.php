<?php

namespace Simina\Middleware;

class Authenticated
{
    public function __invoke($request, $response, $next)
    {
        if(!auth()->check()) {

            return redirect('/auth/login');
        }

        return $next($request, $response);
    }
}