<?php

namespace Simina;

use Simina\Config\Config;
use Simina\Exceptions\MissingPathException;
use Simina\Providers\ConfigServiceProvider;

class App
{
    /**
     * container instance
     *
     * @var \League\Container\Container
     */
    protected $container;

    /**
     * the application's base path
     *
     * @var string
     */
    protected $basePath;

    /**
     * the application's config path
     *
     * @var string
     */
    protected $configPath;

    /**
     * An array of application paths
     *
     * @var array
     */
    protected $settings = [];

    public function __construct(array $settings = ['paths' => [
        'basePath' => __DIR__ . '/../',
        'configPath' => 'config']]) {

    
        $this->setSettings($settings);

        $this->setContainer(\Simina\Singletons::getContainerInstance());

        $this->initializePaths();

        $this->registerBindings();
    }

    /**
     * returns the league container instance
     *
     * @return \League\Container\Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Set the value of basePath
     *
     * @return  void
     */
    public function setBasePath($basePath = null)
    {
        if (!$basePath) {

            $basePath = $this->getPathFromSettings('basePath');
        }

        $this->basePath = $basePath;
    }

    protected function getPathFromSettings($key)
    {
        if($this->pathExistsFromSettings($key)) {

            return $this->settings['paths'][$key];
        }

        throw new MissingPathException("{$key} was not configured
                , please make sure that you set 'paths' arrays to the settings array that is passed to the new instance of 'App'");
    }

    protected function pathExistsFromSettings($key)
    {
        return isset($this->settings['paths'][$key]);
    }

    protected function registerBindings()
    {
        $container = $this->container;

        $this->defaultBindings();

        $this->bindApplicationPaths();

        $config = $container->get(Config::class);

        $providers = $config->get('app.providers');

        foreach ($providers as $provider) {

            $container->addServiceProvider($provider);
        }
    }

    public function defaultBindings()
    {
        $container = $this->container;

        $container->addServiceProvider(new ConfigServiceProvider);
    }

    protected function bindApplicationPaths()
    {

        $container = $this->container;

        $container->share('basePath', function () {

            return $this->basePath;
        });

        $container->share('configPath', function () {

            return $this->basePath. DIRECTORY_SEPARATOR. $this->configPath;
        });


        foreach(config('path') as $key => $value) {

        
            $container->share($key, function() use($value) {

                return $this->basePath . DIRECTORY_SEPARATOR . $value;
            });
        }

    }

    /**
     * Set container instance
     *
     * @param  \League\Container\Container  $container  container instance
     *
     * @return  self
     */
    public function setContainer(\League\Container\Container $container)
    {
        $this->container = $container;
    }

    /**
     * Set an array of application settings
     *
     * @param  array  $paths  An array of application paths
     *
     * @return  void
     */
    public function setSettings(array $settings)
    {
        $this->settings = $settings;

    }

    /**
     * Set the application's config path
     *
     * @param  string  $configPath  the application's config path
     *
     * @return  self
     */ 
    public function setConfigPath(string $configPath = null)
    {
        if(!$configPath) {
            $configPath = $this->getPathFromSettings('configPath');
        }

        $this->configPath = $configPath;
    }

    public function initializePaths()
    {
        $this->setBasePath();
        $this->setConfigPath();
    }
}
