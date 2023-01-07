<?php

namespace App\Utilities\API;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class RestAPIHandlerGuzzle extends RestAPIHandlerBase implements RestAPIHandler
{
    protected Client $client;
    protected array $requestParams = [];

    public function __construct(
        protected array $headers,
        string $uri,
        string $method = 'GET',
        array $requestParams = []
    )
    {
        $this->client = new Client();
        $this->setURI($uri);
        $this->setMethod($method);
        $this->requestParams = $requestParams;
    }

    public function send(): bool
    {
        try {
            $response = $this->client->request(
                $this->method,
                $this->uri,
                array_merge($this->requestParams, ['headers' => $this->headers])
            );
            $this->setResponseCode($response->getStatusCode());
            $this->setResponseContent($response->getBody());
            return true;

        } catch (ClientException) {
            return false;
        }
    }
}
