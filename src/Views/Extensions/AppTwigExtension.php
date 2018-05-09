<?php

namespace Simina\Views\Extensions;

use Simina\Security\Csrf\Csrf;


class AppTwigExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return [

           new \Twig_SimpleFunction('route', function($name, $data = []) {

                return pathForRoute($name);
           }),

           new \Twig_SimpleFunction('config', function($key) {

            return config($key);
           }),

           new \Twig_SimpleFunction('csrf_field', function() {

               return container()->get(Csrf::class)->csrfField();
           }),

           new \Twig_SimpleFunction('auth', function() {

            return auth();
           })
        ];
    }
}