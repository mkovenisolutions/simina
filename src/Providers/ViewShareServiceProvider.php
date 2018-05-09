<?php
namespace Simina\Providers;

use Simina\Views\ViewResolver;
use Simina\Views\Extensions\AppTwigExtension;
use Simina\Storage\Contracts\StorageInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Simina\Security\Auth\Auth;


class ViewShareServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    public function boot()
    {
        $c = $this->getContainer();

    
        $resolver = $c->get(ViewResolver::class);

        $resolver->addExtension(new AppTwigExtension);

        $resolver->share([
            'session' => session(),
            'flash' => flash()
        ]);
    
    }

    public function register(){ }
}