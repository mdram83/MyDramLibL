<?php

namespace App\Utilities\API;

abstract class RestAPIHandlerBase implements RestAPIHandler
{
    protected ?string $uri = null;
    protected ?string $method = null;
    protected ?int $responseCode = null;
    protected mixed $responseContent = null;

    abstract protected function setResponseCode(int $responseCode): void;
    abstract protected function setResponseContent(mixed $responseContent): void;

    public function setURI(string $address): void
    {
        if (static::isValidURI($address)) {
            $this->uri = $address;
        } else {
            throw new RestAPIHandlerException('API issue: Incorrect URI parameter');
        }
    }

    public function getURI(): ?string
    {
        return $this->uri;
    }

    public function setMethod(string $method): void
    {
        if (static::isValidMethod($method)) {
            $this->method = $method;
        } else {
            throw new RestAPIHandlerException('API issue: Incorrect HTTP method parameter');
        }
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function getResponseCode(): int
    {
        return $this->responseCode;
    }

    public function getResponseContent(): mixed
    {
        return $this->responseContent;
    }

    protected static function isValidURI(string $address) : bool
    {
        return (bool) filter_var($address, FILTER_VALIDATE_URL);
    }

    protected static function isValidMethod(string $method) : bool
    {
        return in_array($method, ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], true);
    }
}
