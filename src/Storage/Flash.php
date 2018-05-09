<?php

namespace Simina\Storage;

class Flash
{
    protected $messages;

    protected $key = 'flash';

    public function __construct()
    {
        $this->loadMessages();

        $this->clear();
    }

    public function all() {

        return session()->get($this->key);
    }

    public function get($key, $default = null) {

        if($this->has($key)) {

            return $this->messages[$key];
        }

        return $default;
    }
    
    public function has($key) {

        return isset($this->messages[$key]) && !empty($this->messages[$key]);
    }

    protected function loadMessages()
    {
        $this->messages = $this->all();
    }


    protected function clear() {

        session()->clear($this->key);
    }

    public function put($key , $value) {

        session()->set($this->key, array_merge(

            session()->get($this->key) ?? [], [$key => $value]
        ));
    }
}