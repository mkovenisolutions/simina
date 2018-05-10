<?php

namespace Simina;

class Singletons
{
    /**
     * League Container instance
     *
     * @var \League\Container\Container
     */
    private static $container;


    /**
     * gets the instance of the container
     *
     * @return \League\Container\Container
     */
    public function getContainerInstance()
    {
        if(!static::$container) {

            static::$container = new \League\Container\Container();
            static::$container->delegate(new \League\Container\ReflectionContainer);
        }

        return static::$container;
    }
}