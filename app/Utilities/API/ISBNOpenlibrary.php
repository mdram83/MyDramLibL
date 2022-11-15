<?php

namespace App\Utilities\API;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class ISBNOpenlibrary extends RestAPIHandlerBase
{
    private Client $client;
    private bool $sent = false;

    public function __construct(Client $client, string $isbn)
    {
        $this->client = $client;
        $this->setURI("https://openlibrary.org/api/books?bibkeys=ISBN:$isbn&jscmd=details&format=json");
        $this->setMethod('GET');
    }

    public function setURI(string $address): void
    {
        if (isset($this->uri)) {
            throw new RestAPIHandlerException('API issue: URI already set');
        }
        parent::setURI($address);
    }

    public function setMethod(string $method): void
    {
        if (isset($this->method)) {
            throw new RestAPIHandlerException('API issue: Method already set');
        }
        parent::setMethod($method);
    }

    protected function setResponseCode(int $responseCode): void
    {
        $this->responseCode = $responseCode;
    }

    public function getResponseCode(): int
    {
        if (!$this->sent) {
            $this->send();
        }
        return parent::getResponseCode();
    }

    protected function setResponseContent(mixed $responseContent): void
    {
        $this->responseContent = $responseContent;
    }

    public function getResponseContent(): mixed
    {
        if (!$this->sent) {
            $this->send();
        }
        return parent::getResponseContent();
    }

    public function send(): bool
    {
        if ($this->sent) {
            throw new RestAPIHandlerException('API issue: Request already sent');
        }
        try {
            $this->sent = true;

            $response = $this->client->request($this->getMethod(), $this->uri);

            if ($response->getBody() == '{}') {
                $this->consider404();
                return false;
            }

            $this->setResponseCode($response->getStatusCode());
            $this->setResponseContent($response->getBody());

            return true;

        } catch (ClientException $e) {

            $this->consider404();

            return false;
        }
    }

    private function consider404(): void
    {
        $this->setResponseCode(404);
        $this->setResponseContent(null);
    }
}
