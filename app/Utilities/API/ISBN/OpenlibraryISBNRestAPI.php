<?php

namespace App\Utilities\API\ISBN;

use App\Utilities\API\RestAPIHandlerBase;
use App\Utilities\API\RestAPIHandlerException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class OpenlibraryISBNRestAPI extends RestAPIHandlerBase implements ISBNRestAPI
{
    protected string $isbn;

    public function __construct(protected Client $client)
    {
        $this->setMethod('GET');
    }

    public function setISBN(string $isbn) : void
    {
        $this->isbn = $isbn;
        $this->setURI("https://openlibrary.org/api/books?bibkeys=ISBN:$isbn&jscmd=details&format=json");
    }

    public function send(): bool
    {
        if (!isset($this->isbn)) {
            throw new RestAPIHandlerException('API issue: ISBN not defined');
        }
        try {
            $response = $this->client->request($this->method, $this->uri);

            if ($response->getBody() == '{}') {
                $this->consider404();
                return false;
            }

            $this->setResponseCode($response->getStatusCode());
            $this->setResponseContent($response->getBody());
            return true;

        } catch (ClientException) {
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
            'authors' => [],
            'isbn' => $this->isbn,
            'thumbnail' =>
                $data['covers']['medium'] ?? (
                    $data['covers']['large'] ?? (
                        $data['covers']['small'] ?? (
                            $data['covers'][0] ? 'https://covers.openlibrary.org/b/id/' . $data['covers'][0] . '-M.jpg' : (
                                $data['thumbnail_url'] ?? null
                            )
                        )
                    )
                ),
            'publisher' => $data['publishers'][0] ?? null,
            'published_at' => isset($data['publish_date']) ? substr($data['publish_date'], -4) : null,
            'series' => null,
            'volume' => null,
            'pages' => $data['number_of_pages'] ?? null,
            'tags' => $data['subjects'] ?? [],
        ];

        foreach ($data['authors'] as $author) {
            $splitPosition = strrpos($author['name'], ' ');
            $firstname = trim(substr($author['name'], 0, $splitPosition));
            $lastname = trim(substr($author['name'], $splitPosition));
            $details['authors'][] = $lastname . ($firstname ? ", $firstname" : '');
        }

        if ($series = $data['series'][0] ?? null) {
            $splitPosition = strrpos($series, ', #');
            $details['series'] = ($splitPosition !== false) ? trim(substr($series, 0, $splitPosition)) : trim($series);
            $details['volume'] = ($splitPosition !== false) ? trim(substr($series, $splitPosition + 3)) : null;
        }

        return $details;
    }
}
