<?php


namespace Simina\Security\Csrf;

class Csrf
{
    public $tokenName = '_csrf_token';
    
    protected function generateToken()
    {
        return bin2hex(random_bytes(64));
    }

    public function csrfField()
    {
        $token = $this->generateToken();

        session()->set($this->tokenName, $token);

        return "<input type='hidden' name='{$this->tokenName}' value='{$token}'>";
    }

    protected function getToken()
    {
        return session()->get($this->tokenName);
    }

    public function tokenIsValid($token) {

        return $this->getToken() === $token;
    }


}