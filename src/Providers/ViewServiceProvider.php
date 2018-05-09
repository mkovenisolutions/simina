<?php

namespace Simina\Providers;

use Simina\Views\ViewResolver;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ViewServiceProvider extends AbstractServiceProvider
{
    protected $provides = [ViewResolver::class];

    public function register()
    {
        $c = $this->getContainer();

        $c->share(ViewResolver::class, function(){

            $loader = new \Twig_Loader_Filesystem(templates_path('templates'));

            $twigEnv = new \Twig_Environment($loader, [
                'cache' => false
            ]);
            
            if (config('app.debug')) {
            
                $twigEnv->addExtension(new \Twig_Extension_Debug);
            }

            return new ViewResolver($twigEnv);
        });
    }
}