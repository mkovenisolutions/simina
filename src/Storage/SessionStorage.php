<?php

namespace Simina\Storage;

use Simina\Storage\Contracts\StorageInterface;


class SessionStorage implements StorageInterface
{
    public function has($key)
    {
        return isset($_SESSION[$key]) && !empty($_SESSION[$key]);
    }

    public function get($key, $default = null)
    {
        if($this->has($key)) {

            return $_SESSION[$key];
        }

        return $default;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function clear(...$keys)
    {
        foreach($keys as $key) {

            if($this->has($key)) {

                unset($_SESSION[$key]);
            }
        }
    }
}