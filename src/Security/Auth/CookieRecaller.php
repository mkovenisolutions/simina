<?php

namespace Simina\Security\Auth;

class CookieRecaller
{
    public static $seperator = '|';
    
    public function generate() {

        return [$this->getHash(), $this->getHash()];
    }

    protected function getHash()
    {
        return bin2hex(random_bytes(32));
    }

    public function getHashForCookie($identifier, $token) {

        return $identifier . CookieRecaller::$seperator .$token;
    }

    public function getHashForDb($token) {

        return hash('sha256', $token);
    }

    public function splitCookieValue($value) {

        return explode(CookieRecaller::$seperator, $value);
    }
    public function validateToken($plain, $hashed) {

        return $this->getHashForDb($plain) === $hashed;
    }
}