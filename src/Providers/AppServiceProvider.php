<?php

namespace Simina\Providers;

use Zend\Diactoros\Response;
use League\Route\RouteCollection;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;
use League\Container\ServiceProvider\AbstractServiceProvider;

class AppServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        RouteCollection::class,
        'response',
        'request',
        'emitter'
    ];

    public function register()
    {
        $c = $this->getContainer();
        
        
        $c->share(RouteCollection::class, function() use($c){

            $route = new RouteCollection($c);

            foreach(config('app.middleware') as $middleware) {

                $route->middleware($c->get($middleware));
            }

            return $route;
        });

        $c->share('response', Response::class);

        $c->share('request', function(){
            
            return ServerRequestFactory::fromGlobals(
                $_SERVER, $_GET,$_POST, $_COOKIE, $_FILES
            );;
        });

        $c->share('emitter', SapiEmitter::class);
        
    }
}