<?php

namespace Simina\Middleware;

use Simina\Storage\Contracts\StorageInterface;


class ClearErrorsMiddleware
{
    /**
     * Undocumented variable
     *
     * @var StorageInterface
     */
    protected $session;

    public function __construct(StorageInterface $session)
    {
        $this->session = $session;
    }


    public function __invoke($request, $response, $next)
    {

        $next = $next($request, $response);
        
        $this->session->clear('errors', 'old');

        return $next;
    }
}