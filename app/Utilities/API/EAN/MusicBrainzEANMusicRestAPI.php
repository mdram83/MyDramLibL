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
    private array $artists = [];
    private array $labels = [];
    private array $coverArtReleases = [];
    private array $coverArt = [
        '250' => null,
        'small' => null,
        '500' => null,
        'large' => null,
        '1200' => null,
        'image' => null,
    ];

    private ?string $title = null;
    private ?string $thumbnail = null;
    private ?string $duration = null;
    private ?int $volumes = null;
    private ?string $publisher = null;
    private ?string $published = null;
    private array $tags = [];
    private array $mainArtists = [];
    private array $mainBands = [];

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
        $this->ean = $ean; // not needed later?
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

        $this->parseSearchResponse(json_decode($this->getResponseContent(), true)['releases']);
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

    private function enrichCoverContent(): void
    {
        foreach ($this->coverArtReleases as $mbid) {

            if ($this->thumbnail !== null) {
                return;
            }

            $images = $this->sendCoverRequest($mbid);

            if ($images !== []) {
                $this->parseCoverResponse($images);
            }

        }
    }

    private function parseCoverResponse(array $images): void
    {
        foreach ($images['images'] ?? [] as $image) {
            if ($image['front'] ?? false === true) {
                $this->coverArt['image'] ??= ($image['image'] ?? null);
                $this->coverArt['250'] ??= ($image['thumbnails']['250'] ?? null);
                $this->coverArt['small'] ??= ($image['thumbnails']['small'] ?? null);
                $this->coverArt['500'] ??= ($image['thumbnails']['500'] ?? null);
                $this->coverArt['large'] ??= ($image['thumbnails']['large'] ?? null);
                $this->coverArt['1200'] ??= ($image['thumbnails']['1200'] ?? null);

                $this->thumbnail ??= ($image['thumbnails']['250'] ?? null);
            }
        }
    }

    private function enrichReleaseContent(): void
    {
        foreach ($this->releases as $mbid => $release) {

            $release = $this->sendReleaseRequest($mbid);

            if ($release !== []) {
                $this->parseReleaseResponse($release);
            }

        }
    }

    private function parseSearchResponse(array $releases): void
    {
        foreach ($releases as $release) {

            $this->title ??= ($release['title'] ?? null);
            $this->published ??= isset($release['date']) ? substr($release['date'], 0, 4) : null;

            if (isset($release['media']) && count($release['media']) > 0) {
                $this->volumes ??= count($release['media']);
            }

            $this->releases[$release['id']] = false;

            foreach ($release['artist-credit'] ?? [] as $artist) {
                if (isset($artist['artist']['id'])) {
                    $this->artists[$artist['artist']['id']] = false;
                }
            }

            foreach ($release['label-info'] ?? [] as $label) {
                if (isset($label['label']['id'])) {
                    $this->labels[$label['label']['id']] = false;
                }
            }

        }
    }

    private function parseReleaseResponse(array $release): void
    {
        foreach ($release['artist-credit'] ?? [] as $artist) {
            if ($this->artists[$artist['artist']['id']] === false) {

                $this->artists[$artist['artist']['id']] = true;

                if ($artist['artist']['type'] == 'Person') {
                    $this->mainArtists[] = $artist['artist']['sort-name'];
                } else {
                    $this->mainBands[] = $artist['artist']['name'];
                }
            }
        }

        foreach ($release['label-info'] ?? [] as $label) {
            if (isset($label['label']['id'])) {

                if ($this->labels[$label['label']['id']] === false) {
                    $this->labels[$label['label']['id']] = true;

                    if (($label['label']['type'] ?? '') != 'Imprint') {
                        $this->publisher = $label['label']['name'];
                    }
                }

            }
        }

        $duration = 0;
        foreach ($release['media'] ?? [] as $media) {
            foreach ($media['tracks'] ?? [] as $track) {
                $duration += $track['length'] ?? 0;
                foreach ($track['recording']['tags'] ?? [] as $tag) {
                    if (isset($tag['name'])) {
                        $this->tags[$tag['name']] = $tag['name'];
                    }
                }
            }
        }
        $seconds = round($duration / 1000);

        $this->duration ??= (
            $seconds > 0 ?
            sprintf('%02d:%02d:%02d', ($seconds / 3600), ($seconds / 60 % 60), $seconds % 60) :
            null
        );

        foreach ($release['tags'] ?? [] as $tag) {
            if (isset($tag['name'])) {
                $this->tags[$tag['name']] = $tag['name'];
            }
        }

        foreach ($release['genres'] ?? [] as $genre) {
            if (isset($genre['name'])) {
                $this->tags[$genre['name']] = $genre['name'];
            }
        }

        if (isset($release['cover-art-archive']['count']) && $release['cover-art-archive']['count'] > 0) {
            $this->coverArtReleases[] = $release['id'];
        }




//        dd($this);

//        dd($release);
    }

    public function getParsedContent(): array
    {
        if ($this->responseCode !== 200) {
            throw new RestAPIHandlerException('Can not parse content for unsuccessful request');
        }

        // here set thumbnail if was not set before (e.g. no 250 image, but others) (call parser function);

        return [
            'ean' => $this->ean,
            'thumbnail' => $this->thumbnail, // may not be set, then pick in order from 250 to image
            'title' => $this->title,
            'duration' => $this->duration,
            'volumes' => $this->volumes,
            'publisher' => $this->publisher,
            'published' => $this->published,
            'mainArtists' => $this->mainArtists,
            'mainBands' => $this->mainBands,
            'tags' => $this->tags,
        ];
    }

    private function consider404(): void
    {
        $this->setResponseCode(404);
        $this->setResponseContent(null);
    }
}
