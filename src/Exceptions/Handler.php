<?php namespace Simina\Exceptions;

use Simina\Storage\Contracts\StorageInterface;

class Handler
{
    /**
     * Undocumented variable
     *
     * @var \Exception
     */
    protected $exception;

    public function __construct(\Exception $e)
    {
        $this->exception = $e;
    }
    public function respond()
    {
        $class = (new \ReflectionClass($this->exception))->getShortName();

        if(method_exists($this, $method = "handle{$class}")) {

            return $this->{$method}($this->exception);
        }

        return $this->unhandledException($this->exception);
    }


    public function handleValidationException(ValidationException $e)
    {
        $session = container()->get(StorageInterface::class);

        $session->set('errors', $e->getErrors());
        $session->set('old', $e->old());

        return redirect($e->getPath());
    }

    public function handleInvalidRequestException(InvalidRequestException $e) {

        return view('framework/exceptions/csrf.twig', ['exception' => $e]);
    }

    public function unhandledException(\Exception $e)
    {
        throw $e;
    }   
}