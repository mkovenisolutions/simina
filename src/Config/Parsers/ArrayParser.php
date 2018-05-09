<?php

namespace Simina\Config\Parsers;

use Simina\Config\Contracts\ParserInterface;

class ArrayParser implements ParserInterface
{
    protected $files;

    public function __construct(array $files)
    {
        $this->files = $files;
    }

    public function parse()
    {
        $items = [];

        foreach($this->files as $key => $file) {
            
            $items[$key] = require_once $file;
        }

        return $items;
    }
}