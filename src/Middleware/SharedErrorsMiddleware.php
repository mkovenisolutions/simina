<?php

namespace Simina\Middleware;

use Simina\Views\ViewResolver;
use Simina\Storage\Contracts\StorageInterface;


class SharedErrorsMiddleware
{
    /**
     * Undocumented variable
     *
     * @var ViewResolver
     */
    protected $viewResolver;

    /**
     * Undocumented variable
     *
     * @var StorageInterface
     */
    protected $session;

    public function __construct(ViewResolver $resolver, StorageInterface $session)
    {
        $this->viewResolver = $resolver;
        $this->session = $session;
    }


    public function __invoke($request, $response, $next)
    {
        $this->viewResolver->share([
            'errors' => $this->session->get('errors', []),
            'old' => $this->session->get('old')
            ]);
    

        return $next($request, $response);next;
    }
}