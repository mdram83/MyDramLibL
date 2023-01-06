<?php

namespace App\Utilities\API\Spotify;

use App\Utilities\API\RestAPIHandlerBase;
use App\Utilities\API\RestAPIHandlerException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class SpotifyRestAPI extends RestAPIHandlerBase
{
    protected SpotifyRestAPIAuthorization $authorization;
    protected string $ean;
    protected array $headers;

    public function __construct(
        protected Client $client,
    )
    {
        $this->authorization = new SpotifyRestAPIAuthorization();
        $this->method = 'GET';
        $this->headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->authorization->getTokenType() . ' ' . $this->authorization->getAccessToken(),
        ];
    }

    public function setEAN(string $ean): void
    {
        $this->ean = $ean;
        $this->setURI('https://api.spotify.com/v1/search?q=upc%3A' . $ean . '&type=album');
    }

    public function send(): bool
    {
        if (!isset($this->ean)) {
            throw new RestAPIHandlerException('API issue: EAN not defined');
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
