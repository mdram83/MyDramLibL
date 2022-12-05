<?php

namespace App\Utilities\API\EAN;

use App\Utilities\API\RestAPIHandlerBase;
use App\Utilities\API\RestAPIHandlerException;
use App\Utilities\API\RestAPIHandlerGuzzle;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class MusicBrainzEANMusicRestAPI extends RestAPIHandlerBase implements EANMusicRestAPI
{
    protected array $headers;
    protected string $ean;
    protected array $uriConfig = [
        'search' => [
            'prefix' => 'https://musicbrainz.org/ws/2/',
            'main' => 'release?query=barcode:',
            'suffix' => '',
        ],
        'release' => [
            'prefix' => 'https://musicbrainz.org/ws/2/',
            'main' => 'release/',
            'suffix' => '?inc=artists+labels+recordings+tags+genres',
        ],
        'cover' => [
            'prefix' => 'https://coverartarchive.org/',
            'main' => 'release/',
            'suffix' => '',
        ],
    ];
    protected array $releases = [];
    protected array $coverArtReleases = [];
    protected MusicBrainzEANParser $parser;

    public function __construct(protected Client $client)
    {
        $this->headers = [
            'User-Agent' => config('services.musicbrainz.user_agent'),
            'Accept' => 'application/json',
        ];
        $this->setMethod('GET');
        $this->parser = new MusicBrainzEANParser($this);
    }

    public function setEAN(string $ean) : void
    {
        $this->ean = $ean;
        $this->parser->setEAN($ean);
        $this->setURI($this->prepareUri('search', $ean));
    }

    public function send(): bool
    {
        if (!isset($this->ean)) {
            throw new RestAPIHandlerException('API issue: EAN not defined');
        }

        try {

            if (!$this->sendSearchRequest()) {

                $this->consider404();
                return false;
            }

        } catch (ClientException) {

            $this->consider404();
            return false;
        }

        $this->parser->parseSearchResponse(json_decode($this->getResponseContent(), true)['releases']);
        $this->enrichReleaseContent();
        $this->enrichCoverContent();

        return true;
    }

    public function getParsedContent(): array
    {
        if ($this->responseCode !== 200) {
            throw new RestAPIHandlerException('Can not parse content for unsuccessful request');
        }

        return $this->parser->getContent();
    }

    public function addRelease(string $release): void
    {
        $this->releases[$release] = $release;
    }

    public function addCoverArtRelease(string $release): void
    {
        $this->coverArtReleases[$release] = $release;
    }

    protected function prepareUri(string $requestType, ?string $body): string
    {
        return
            $this->uriConfig[$requestType]['prefix'] .
            $this->uriConfig[$requestType]['main'] .
            ($body ?? '') .
            $this->uriConfig[$requestType]['suffix'];
    }

    protected function sendSearchRequest(): bool
    {
        $response = $this->client->request($this->method, $this->uri, ['headers' => $this->headers]);

        if (json_decode($response->getBody(), true)['releases'] == []) {
            return false;
        }

        $this->setResponseCode($response->getStatusCode());
        $this->setResponseContent($response->getBody());

        return true;
    }

    protected function sendReleaseRequest(string $mbid): array
    {
        try {
            $releaseAPI = new RestAPIHandlerGuzzle(
                $this->headers,
                $this->prepareUri('release', $mbid)
            );
            $releaseAPI->send();

        } catch (ClientException) {
            return [];
        }

        return json_decode($releaseAPI->getResponseContent(), true);
    }

    protected function sendCoverRequest(string $mbid): array
    {
        try {
            $coverAPI = new RestAPIHandlerGuzzle(
                $this->headers,
                $this->prepareUri('cover', $mbid)
            );
            $coverAPI->send();

        } catch (ClientException) {
            return [];
        }

        return json_decode($coverAPI->getResponseContent(), true);
    }

    protected function enrichReleaseContent(): void
    {
        foreach ($this->releases as $mbid) {

            $release = $this->sendReleaseRequest($mbid);

            if ($release !== []) {
                $this->parser->parseReleaseResponse($release);
            }

        }
    }

    protected function enrichCoverContent(): void
    {
        foreach ($this->coverArtReleases as $mbid) {

            if ($this->parser->getThumbnail() !== null) {
                return;
            }

            $images = $this->sendCoverRequest($mbid);

            if ($images !== []) {
                $this->parser->parseCoverResponse($images);
            }

        }
    }
}
