<?php

namespace App\Utilities\API\Spotify;

use App\Utilities\API\RestAPIHandlerBase;
use App\Utilities\API\RestAPIHandlerException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class SpotifyRestAPI extends RestAPIHandlerBase
{
    protected array $headers;

    protected string $uriPrefix = 'https://api.spotify.com/v1/search?q=';
    protected string $uriSuffix = '&type=album&limit=1';

    public function __construct(protected Client $client, protected SpotifyRestAPIAuthorization $authorization)
    {
        $this->method = 'GET';
        $this->headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->authorization->getTokenType() . ' ' . $this->authorization->getAccessToken(),
        ];
    }

    public function setEAN(string $ean): void
    {
        $this->setURI("{$this->uriPrefix}upc%3A{$ean}{$this->uriSuffix}");
    }

    public function setTitleAndArtist(string $title, string $artist = null): void
    {
        $title = rawurlencode($title);
        $artist = isset($artist) ? rawurlencode($artist) : null;

        $this->setURI(
            "{$this->uriPrefix}album%3D{$title}"
            . (isset($artist) ? "%26artist%3D{$artist}" : '')
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

            if (json_decode($response->getBody(), true)['albums']['items'] == []) {
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

        $data = json_decode($this->responseContent, true)['albums']['items'][0];

        $details['spotify_app_link'] = $data['uri'];
        $details['spotify_web_link'] = $data['external_urls']['spotify'];

        return $details;
    }
}
