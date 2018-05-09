<?php

namespace Simina;

use Simina\Config\Config;
use Simina\Providers\ConfigServiceProvider;
use League\Container\ServiceProvider\AbstractServiceProvider;


class App
{
    private static $container;

    public static function getContainerInstance()
    {
        
        if(!self::$container) {


            self::$container = new \League\Container\Container();

            self::$container->delegate(new \League\Container\ReflectionContainer);

            self::$container->addServiceProvider(new ConfigServiceProvider);
            
            $config = self::$container->get(Config::class);

            
            $providers = $config->get('app.providers');


            foreach($providers as $provider) {

                self::$container->addServiceProvider($provider);
            }

      
        }

        return self::$container;
    }
}