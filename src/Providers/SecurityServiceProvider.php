<?php

namespace Simina\Providers;

use Simina\Security\Auth\Auth;
use Doctrine\ORM\EntityManager;
use Simina\Security\Hashing\Hasher;
use Simina\Security\Hashing\BcryptHasher;
use Simina\Storage\Contracts\StorageInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Simina\Security\Csrf\Csrf;
use Simina\Security\Auth\CookieRecaller;



class SecurityServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Hasher::class,
        Auth::class,
        Csrf::class,
        CookieRecaller::class
    ];

    public function register()
    {
        $c = $this->getContainer();

        $c->share(Hasher::class, function() {
            
            return new BcryptHasher;
        });

        $c->share(CookieRecaller::class, function() {

            return new CookieRecaller;
        });

        $c->share(Auth::class, function() use($c) {

            return new Auth(
                $c->get(EntityManager::class),
                $c->get(Hasher::class),
                $c->get(CookieRecaller::class)
            );
        });

        

        $c->share(Csrf::class, function() {
            
            return new Csrf;
        });
    }
}