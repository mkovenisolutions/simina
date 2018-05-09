<?php

namespace Simina\Providers;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use League\Container\ServiceProvider\AbstractServiceProvider;

class DatabaseServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        EntityManager::class
    ];


    public function register()
    {
        $c = $this->getContainer();

        $c->share(EntityManager::class, function() {

            $setup = Setup::createAnnotationMetadataConfiguration([base_path('/src/Models')], config('app.debug')); 

            $em = EntityManager::create(config('db.mysql'), $setup);

            return $em;
           
        });
    }

}