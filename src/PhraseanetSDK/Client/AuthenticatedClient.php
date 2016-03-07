<?php

namespace PhraseanetSDK\Client;

use Psr\Http\Message\RequestInterface;

class AuthenticatedClient implements Client
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $token;

    /**
     * @param Client $client
     * @param string $token
     */
    public function __construct(Client $client, $token)
    {
        $this->client = $client;
        $this->token = $token;
    }

    /**
     * @param RequestInterface $request
     * @return ApiResponse $response
     */
    public function call(RequestInterface $request)
    {
        $uriParts = parse_url($request->getUri()->getPath());
        $uriQuery = '';
        $queryParts = [];

        if (isset($uriParts['query'])) {
            $uriQuery = $uriParts['query'];
        }

        parse_str($uriQuery, $queryParts);

        if (! isset($queryParts['oauth_token'])) {
            $queryParts['oauth_token'] = $this->token;
        }

        $request = $request->withUri($request->getUri()->withQuery(http_build_query($queryParts)));

        return $this->client->call($request);
    }
}
