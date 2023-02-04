<?php

namespace App\Utilities\API\YouTube;

use App\Utilities\API\RestAPIHandlerException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class YouTubeRestAPI extends \App\Utilities\API\RestAPIHandlerBase
{

    protected array $headers;
    protected string $uriPrefix = 'https://youtube.googleapis.com/youtube/v3/search?part=snippet&maxResults=1&q=';
    protected string $uriSuffix = '&type=playlist&key=';
    protected string $linkPrefix = 'https://www.youtube.com/playlist?list=';

    public function __construct(protected Client $client)
    {
        $this->method = 'GET';
        $this->headers = [
            'Accept' => 'application/json',
        ];
        $this->uriSuffix .= config('services.youtube.api.key');
    }

    public function setTitleAndArtist(string $title, string $artist = null): void
    {
        $this->setURI(
            $this->uriPrefix
            . rawurlencode((isset($artist) ? "$artist " : '') . $title)
            . $this->uriSuffix
        );
    }


    public function send(): bool
    {
        if (!isset($this->uri)) {
            throw new RestAPIHandlerException('API issue: search parameter not defined');
        }

        try {

            $response = $this->client->request($this->method, $this->uri, ['headers' => $this->headers]);

            if (json_decode($response->getBody(), true)['items'] == []) {
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

        $playlistId = json_decode($this->responseContent, true)['items'][0]['id']['playlistId'];
        return ['link' => $this->linkPrefix . $playlistId];
    }
}
