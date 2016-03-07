<?php

namespace PhraseanetSDK\Client;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;

class GuzzleClient implements Client
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param RequestInterface $request
     * @return ApiResponse $response
     */
    public function call(RequestInterface $request)
    {
        return $this->client->send($request);
    }
}
