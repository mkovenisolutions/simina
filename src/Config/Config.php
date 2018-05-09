<?php

namespace Simina\Config;

use Simina\Config\Contracts\ParserInterface;

class Config
{
    protected $parser;
    public $items = [];

    public function __construct(ParserInterface $parser)
    {   
        $this->setParser($parser);
    }


    public function setParser(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    public function load()
    {
        $this->items = $this->parser->parse();
    }

    public function get($keys, $default = null)
    {
        $localItems = $this->items;

        //config.get('app.providers')

        foreach(explode('.', $keys) as $key) {

            if(!array_key_exists($key, $localItems)) {

                return $default;
            }

            $localItems = $localItems[$key];
        }

        return $localItems;
    }

}