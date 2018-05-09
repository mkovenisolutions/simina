<?php

namespace Simina\Middleware;

use Exception;


class AuthenticateWithCookie
{

    public function __invoke($request, $response, $next)
    {
        if(auth()->check()) {

            return $next($request, $response);
        }

        if(auth()->hasRemember()) {

            try {
                
                auth()->setUserFromCookie();
            }
            catch(Exception $e) {
                auth()->logout();
            }  
        }
        
        return $next($request, $response);
    }
}