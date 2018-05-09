<?php

namespace Simina\Middleware;

use League\Route\Http\Exception;


class Authenticate
{

    public function __invoke($request, $response, $next)
    {
        $user = auth()->hasUserInSession();
        
        if($user) {

            try {

                auth()->setUserFromSession();

            }
            catch(Exception $e) {

                dump($c);
                //logout
            }
        }
        
        return $next($request, $response);
    }
}