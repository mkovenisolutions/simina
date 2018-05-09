<?php

namespace Simina\Providers;

use Simina\Storage\SessionStorage;
use Simina\Storage\Contracts\StorageInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Simina\Storage\Flash;
use Simina\Storage\Cookie;



class StorageServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        StorageInterface::class,
        Flash::class,
        Cookie::class
    ];

    public function register()
    {
        $c = $this->getContainer();

        $c->share(StorageInterface::class, function() {

            return new SessionStorage;
        });

        $c->share(Cookie::class, function() {

            return new Cookie;
        });

        $c->share(Flash::class, function() {

            return new Flash;
        });
    }
}