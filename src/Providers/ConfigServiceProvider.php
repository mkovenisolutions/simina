<?php

namespace Simina\Providers;

use Simina\Config\Config;
use Zend\Diactoros\Response;
use Simina\Config\Parsers\ArrayParser;
use League\Container\ServiceProvider\AbstractServiceProvider;


class ConfigServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Config::class
    ];

    public function register()
    {
        $c = $this->getContainer();

        $c->share(Config::class, function() {

            $arrayParser = new ArrayParser([
                'app' => config_path('app.php'),
                'auth' => config('auth.php'),
                'db' => config_path('database.php'),
                'security' => config_path('security.php'),
                'path' => config_path('path.php')
            ]);

            $config = new Config($arrayParser);

            $config->load();

            return $config;
        });
    }
}