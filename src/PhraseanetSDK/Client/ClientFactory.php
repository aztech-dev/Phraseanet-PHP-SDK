<?php

namespace PhraseanetSDK\Client;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;

class ClientFactory
{

    private $cacheConfiguration;

    public function __construct(array $cacheConfiguration)
    {
        $this->cacheConfiguration = $cacheConfiguration;
    }

    /**
     * @param array $options
     * @return Client
     */
    public function getClient(array $options)
    {
        $history = [];
        $stack = HandlerStack::create();

        $stack->push(Middleware::history($history));
    }
}
