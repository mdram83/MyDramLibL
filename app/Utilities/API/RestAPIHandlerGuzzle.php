<?php

namespace App\Utilities\API;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class RestAPIHandlerGuzzle extends RestAPIHandlerBase implements RestAPIHandler
{

    protected Client $client;

    public function __construct(
        protected array $headers,
        string $uri,
        string $method = 'GET'
    )
    {
        $this->client = new Client();
        $this->setURI($uri);
        $this->setMethod($method);
    }

    public function send(): bool
    {
        try {
            $response = $this->client->request($this->method, $this->uri, ['headers' => $this->headers]);
            $this->setResponseCode($response->getStatusCode());
            $this->setResponseContent($response->getBody());
            return true;

        } catch (ClientException) {
            return false;
        }
    }

    protected function setResponseCode(int $responseCode): void
    {
        $this->responseCode = $responseCode;
    }

    protected function setResponseContent(mixed $responseContent): void
    {
        $this->responseContent = $responseContent;
    }

}
