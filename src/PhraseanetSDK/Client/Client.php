<?php

namespace PhraseanetSDK\Client;

use Psr\Http\Message\RequestInterface;

interface Client
{
    /**
     * @param RequestInterface $request
     * @return ApiResponse $response
     */
    public function call(RequestInterface $request);
}
