<?php


namespace Simina\Exceptions;

use League\Route\Http\Exception;
use Psr\Http\Message\ServerRequestInterface;


class ValidationException extends Exception
{
    /**
     * Undocumented variable
     *
     * @var ServerRequestInterface
     */
    protected $request;

    protected $errors = [];

    public function __construct(ServerRequestInterface $request, $errors)
    {
        $this->request = $request;

        $this->errors = $errors;
    }

    public function getPath()
    {
        return $this->request->getUri()->getPath();
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function old() {

        return $this->request->getParsedBody();
    }
}