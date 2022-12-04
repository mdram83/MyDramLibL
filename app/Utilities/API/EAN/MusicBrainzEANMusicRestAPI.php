<?php

namespace App\Utilities\API\EAN;

use App\Utilities\API\RestAPIHandlerBase;
use App\Utilities\API\RestAPIHandlerException;
use App\Utilities\API\RestAPIHandlerGuzzle;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class MusicBrainzEANMusicRestAPI extends RestAPIHandlerBase implements EANMusicRestAPI
{
    private array $headers;
    private string $ean;
    private bool $sent = false;

    private array $uriConfig = [
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

    private MusicBrainzEANParser $parser;

    private array $releases = [];
    private array $coverArtReleases = [];

    public function __construct(private Client $client)
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

    private function prepareUri(string $requestType, ?string $body): string
    {
        return
            $this->uriConfig[$requestType]['prefix'] .
            $this->uriConfig[$requestType]['main'] .
            ($body ?? '') .
            $this->uriConfig[$requestType]['suffix'];
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

        if (!isset($this->ean)) {
            throw new RestAPIHandlerException('API issue: EAN not defined');
        }

        $this->sent = true;

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

    private function sendSearchRequest(): bool
    {
        $response = $this->client->request($this->getMethod(), $this->uri, ['headers' => $this->headers]);

        if (json_decode($response->getBody(), true)['releases'] == []) {
            return false;
        }

        $this->setResponseCode($response->getStatusCode());
        $this->setResponseContent($response->getBody());

        return true;
    }

    private function sendReleaseRequest(string $mbid): array
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

    private function sendCoverRequest(string $mbid): array
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

    private function enrichReleaseContent(): void
    {
        foreach ($this->releases as $mbid => $release) {

            $release = $this->sendReleaseRequest($mbid);

            if ($release !== []) {
                $this->parser->parseReleaseResponse($release);
            }

        }
    }

    private function enrichCoverContent(): void
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

    public function getParsedContent(): array
    {
        if ($this->responseCode !== 200) {
            throw new RestAPIHandlerException('Can not parse content for unsuccessful request');
        }

        return $this->parser->getContent();
    }

    public function addRelease(string $release): void
    {
        $this->releases[$release] = false; // REQUIRED FOR ENRICHEMENT, DIFFERENT FORMAT?
    }

    public function addCoverArtRelease(string $release): void
    {
        $this->coverArtReleases[] = $release; // REQUIRED FOR COVERS, DIFFERENT FORMAT?
    }

    private function consider404(): void
    {
        $this->setResponseCode(404);
        $this->setResponseContent(null);
    }
}
