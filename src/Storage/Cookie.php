<?php

namespace Simina\Storage;

class Cookie
{
    protected $expiry;

    protected $secure = false;

    protected $httpOnly = true;

    protected $path = '/';

    protected $domain = '';


    public function __construct($expiry = 86400)
    {
        $this->expiry = $expiry;
    }

    public function set($key, $value) {

        setcookie($key, $value, time() + $this->expiry,$this->path,
         $this->domain, $this->secure, $this->httpOnly);
    }

    public function get($key, $default=null) {

        if($this->has($key)) {

            return $_COOKIE[$key];
        }

        return $default;
    }

    public function has($key) {

        return isset($_COOKIE[$key]) && !empty($_COOKIE[$key]);
    }

    public function clear($key) {

        $this->set($key, null, -2 *$this->expiry);
    }
}