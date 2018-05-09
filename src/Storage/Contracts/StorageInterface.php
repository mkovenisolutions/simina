<?php

namespace Simina\Storage\Contracts;

interface StorageInterface
{
    function has($key);

    function get($key, $default= null);

    function set($key, $value);

    function clear(...$keys);
}