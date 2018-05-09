<?php

namespace Simina\Middleware;

class Guest
{
    public function __invoke($request, $response, $next)
    {
        if(auth()->check()) {

            return redirect('/');
        }

        return $next($request, $response);
    }
}