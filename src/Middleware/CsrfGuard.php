<?php

namespace Simina\Middleware;

use Simina\Security\Csrf\Csrf;
use Psr\Http\Message\ServerRequestInterface;
use Simina\Exceptions\InvalidRequestException;


class CsrfGuard
{
    /**
     * Csrf instance
     *
     * @var \Simina\Security\Csrf\Csrf
     */
    protected $csrf;

    public function __construct(Csrf $csrf)
    {
        $this->csrf = $csrf;
    }

    public function __invoke(ServerRequestInterface $request, $response, $next)
    {
        if(!$this->requestRequiresGuard($request)) {
            
            return $next($request, $response);
        }

        if($this->isCsrfGuardEnabled()) {

            if(!$this->isTokenValid($request)) {

                throw new InvalidRequestException("Your request is invalid, this is likely to 
                happen when your session has expire. Please press the back button on your browser and try again.");
            }
        }

        return $next($request, $response);
        
    }

    protected function isCsrfGuardEnabled() {

        return config('security.csrf.enabled');
    }

    protected function requestRequiresGuard($request) {

        return in_array($request->getMethod(), ['POST','PATCH','PUT', 'DELETE']);
    }

    protected function isTokenValid($request) {

        $token = $request->getParsedBody()[$this->csrf->tokenName];

        return $this->csrf->tokenIsValid($token);
    }
}