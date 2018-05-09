<?php

use Zend\Diactoros\Response\RedirectResponse;
use Simina\Security\Auth\Auth;
use Simina\Storage\Contracts\StorageInterface;
use Simina\Storage\Flash;
use Simina\Storage\Cookie;

if(!function_exists('auth')) {

    /**
     * Authentication class instanace
     *
     * @return Auth
     */
    function auth()
    {
        return container()->get(Auth::class);
    }
}

/**
 * PATH Helpers
 */
if (!function_exists('base_path')) {

    function base_path($path = '')
    {

        return __DIR__ . '/..//' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}


if(!function_exists('config_path')) {

   function config_path($path = '')
   {
    return base_path('config/' . $path);
   }
}

if(!function_exists('templates_path')) {

    function templates_path($path = '')
    {
     return base_path('templates/' . $path);
    }
 }

 if(!function_exists('public_path')) {

    function public_path($path = '')
    {
     return base_path('public/' . $path);
    }
 }

 if(!function_exists('routes_path')) {

    function routes_path($path = '')
    {
     return base_path('routes/' . $path);
    }
 }

 if(!function_exists('assets_path')) {

    function assets_path($path = '')
    {
     return base_path('assets/' . $path);
    }
 }

//End of path helpers
if (!function_exists('config')) {

    function config($key)
    {

        $config = container()->get(\Simina\Config\Config::class);

        return $config->get($key);
    }
}

if (!function_exists('container')) {

    /**
     * returns a container instance
     *
     * @return \League\Container\Container
     */
    function container()
    {

        return \Simina\App::getContainerInstance();
    }
}

if (!function_exists('cookie')) {

    /**
     * returns a container instance
     *
     * @return \Simina\Storage\Cookie;
     */
    function cookie()
    {

        return container()->get(Cookie::class);
    }
}

if (!function_exists('env')) {

    function env($key, $default = null)
    {

        $value = getenv($key);

        if (!$value) {

            return $default;
        }

        if ($value === 'true') {
            return true;
        }

        if ($value === 'false') {
            return false;
        }

        return $value;
    }
}

if(!function_exists('flash')) {

    /**
     * Undocumented function
     *
     * @return \Simina\Storage\Flash
     */
    function flash() {

        return container()->get(Flash::class);
    }
};

if (!function_exists('pathForRoute')) {

    function pathForRoute($name)
    {

        $route = container()->get(\League\Route\RouteCollection::class);

        return $route->getNamedRoute($name)->getPath();
    }
}

if (!function_exists('redirect')) {

    function redirect($uri, $status = 302, array $headers = [])
    {

        return new RedirectResponse($uri, $status, $headers);
    }
}

if(!function_exists('session')) {
    /**
     * storage interface 
     *
     * @return \Simina\Storage\Contracts\StorageInterface
     */
    function session() {

        return container()->get(StorageInterface::class);
    }
}

if (!function_exists('view')) {

    function view($view, $data = [])
    {

        $resolver = container()->get(\Simina\Views\ViewResolver::class);
        $response = container()->get('response');

        return $resolver->render($response, $view, $data);
    }
}
