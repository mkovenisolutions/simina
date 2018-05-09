<?php

namespace Simina\Views;

use Doctrine\ORM\Mapping\Driver\YamlDriver;


class ViewResolver
{
 
    /**
     * Undocumented variable
     *
     * @var \Twig_Environment
     */
    protected $twigEnv;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twigEnv = $twig;
    }
    public function render($response, $view, $data = [])
    {
        $response->getBody()->write(

            $this->twigEnv->render($view, $data)
        );


        return $response;
    }

    public function addExtension(\Twig_Extension $extension)
    {
        $this->twigEnv->addExtension($extension);
    }

    public function share(array $items)
    {
        foreach($items as $key => $value) {
            $this->twigEnv->addGlobal($key, $value);
        }
    }
}