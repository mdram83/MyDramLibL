<?php

namespace App\Utilities\API\ISBN;

use App\Utilities\API\RestAPIHandlerBase;
use App\Utilities\API\RestAPIHandlerException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class OpenlibraryISBNRestAPI extends RestAPIHandlerBase implements ISBNRestAPI
{
    private Client $client;
    private string $isbn;
    private bool $sent = false;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->setMethod('GET');
    }

    public function setISBN(string $isbn) : void
    {
        $this->isbn = $isbn;
        $this->setURI("https://openlibrary.org/api/books?bibkeys=ISBN:$isbn&jscmd=details&format=json");
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
        if (!isset($this->isbn)) {
            throw new RestAPIHandlerException('API issue: ISBN not defined');
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

    public function getParsedContent(): array
    {
        if ($this->responseCode !== 200) {
            throw new RestAPIHandlerException('Can not parse content for unsuccessful request');
        }
        $data = json_decode($this->responseContent, true)["ISBN:{$this->isbn}"]['details'];

        $details = [
            'title' => $data['title'] ?? null,
            'authorFirstname' => null,
            'authorLastname' => null,
            'isbn' => $this->isbn,
            'publisher' => $data['publishers'][0] ?? null,
            'published_at' => $data['publish_date'] ?? null,
            'series' => null,
            'volume' => null,
            'pages' => $data['number_of_pages'] ?? null,
            'tags' => $data['subjects'] ?? [],
        ];

        // TODO adjust to many authors
        if ($author = $data['authors'][0]['name'] ?? null) {
            $splitPosition = strrpos($author, ' ');
            $details['authorFirstname'] = trim(substr($author, 0, $splitPosition));
            $details['authorLastname'] = trim(substr($author, $splitPosition));
        }

        if ($series = $data['series'][0] ?? null) {
            $splitPosition = strrpos($series, ', #');
            $details['series'] = ($splitPosition !== false) ? trim(substr($series, 0, $splitPosition)) : trim($series);
            $details['volume'] = ($splitPosition !== false) ? trim(substr($series, $splitPosition + 3)) : null;
        }

        return $details;
    }

    private function consider404(): void
    {
        $this->setResponseCode(404);
        $this->setResponseContent(null);
    }
}
