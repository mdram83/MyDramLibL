<?php

namespace App\Utilities\API;

abstract class RestAPIHandlerBase implements RestAPIHandler
{
    protected ?string $uri;
    protected ?string $method;
    protected ?int $responseCode;
    protected mixed $responseContent;

    public function getResponseCode(): int
    {
        if (!isset($this->responseCode)) {
            throw new RestAPIHandlerException('Request code not set');
        }
        return $this->responseCode;
    }

    public function getResponseContent(): mixed
    {
        if (!isset($this->responseCode)) {
            throw new RestAPIHandlerException('Request code not set');
        }
        return $this->responseContent;
    }

    protected function setResponseCode(int $responseCode): void
    {
        $this->responseCode = $responseCode;
    }

    protected function setResponseContent(mixed $responseContent): void
    {
        $this->responseContent = $responseContent;
    }

    protected function setURI(string $address): void
    {
        if (!static::isValidURI($address)) {
            throw new RestAPIHandlerException('Incorrect URI parameter');
        }
        $this->uri = $address;
    }

    protected function setMethod(string $method): void
    {
        if (!static::isValidMethod($method)) {
            throw new RestAPIHandlerException('API issue: Incorrect HTTP method parameter');

        }
        $this->method = $method;
    }

    protected static function isValidURI(string $address) : bool
    {
        return (bool) filter_var($address, FILTER_VALIDATE_URL);
    }

    protected static function isValidMethod(string $method) : bool
    {
        return in_array($method, ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], true);
    }

    protected function consider404(): void
    {
        $this->setResponseCode(404);
        $this->setResponseContent(null);
    }
}
