<?php

namespace App\Utilities\API\EAN;

class MusicBrainzEANParser
{

    private array $releases = [];
    private array $coverArtReleases = [];
    private array $coverArt = [
        '250' => null,
        'small' => null,
        '500' => null,
        'large' => null,
        '1200' => null,
        'image' => null,
    ];

    private ?string $ean = null;
    private ?string $title = null;
    private ?string $thumbnail = null;
    private ?string $duration = null;
    private ?int $volumes = null;
    private ?string $publisher = null;
    private ?string $published = null;
    private array $tags = [];
    private array $mainArtists = [];
    private array $mainBands = [];

    public function __construct(private MusicBrainzEANMusicRestAPI $api)
    {

    }

    public function parseSearchResponse(array $releases): void
    {
        foreach ($releases as $release) {

            $this->setTitle($release['title'] ?? null);
            $this->setPublished($release['date'] ?? null);
            $this->setVolumes($release['media'] ?? []);

            $this->releases[$release['id']] = false; // REQUIRED FOR ENRICHEMENT, DIFFERENT FORMAT?
        }
    }

    public function parseReleaseResponse(array $release): void
    {
        $this->addMainArtistsOrMainBands($release['artist-credit'] ?? []);
        $this->setPublisher($release['label-info'] ?? []);
        $this->setDurationAndAddRecordingTags($release['media'] ?? []);

        $this->addTags($release['tags'] ?? []);
        $this->addTags($release['genres'] ?? []);

        if (isset($release['cover-art-archive']['count']) && $release['cover-art-archive']['count'] > 0) {
            $this->coverArtReleases[] = $release['id']; // REQUIRED FOR COVERS, DIFFERENT FORMAT?
        }
    }

    private function parseCoverResponse(array $images): void
    {
        foreach ($images as $image) {

            if ($image['front'] ?? false === true) {
                $this->coverArt['image'] ??= ($image['image'] ?? null);
                $this->coverArt['250'] ??= ($image['thumbnails']['250'] ?? null);
                $this->coverArt['small'] ??= ($image['thumbnails']['small'] ?? null);
                $this->coverArt['500'] ??= ($image['thumbnails']['500'] ?? null);
                $this->coverArt['large'] ??= ($image['thumbnails']['large'] ?? null);
                $this->coverArt['1200'] ??= ($image['thumbnails']['1200'] ?? null);

                if (isset($this->coverArt['250'])) {
                    $this->thumbnail = $this->coverArt['250'];
                    return;
                }
            }
        }
    }

    private function setBestCoverForThumbnail(): void
    {
        if (isset($this->thumbnail)) {
            return;
        }
        $this->thumbnail =
            $this->coverArt['250'] ?? (
                $this->coverArt['small'] ?? (
                    $this->coverArt['500'] ?? (
                        $this->coverArt['large'] ?? (
                            $this->coverArt['1200'] ?? (
                                $this->coverArt['image'] ?? null
        )))));
    }

    public function getContent(): array
    {
        $this->setBestCoverForThumbnail();

        return [
            'ean' => $this->ean, // this one not set...
            'thumbnail' => $this->thumbnail,
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

    public function setEAN(string $ean): void
    {
        $this->ean = $ean;
    }

    private function setTitle(?string $title): void
    {
        $this->title ??= $title;
    }

    private function setPublished(?string $date): void
    {
        $this->published ??= isset($date) ? substr($date, 0, 4) : null;
    }

    private function setVolumes(array $media): void
    {
        $this->volumes ??= (count($media) > 0 ? count($media) : null);
    }

    private function addMainArtistsOrMainBands(array $artists): void
    {
        foreach ($artists as $artist) {
            if ($artist['artist']['type'] == 'Person') {
                $this->mainArtists[$artist['artist']['sort-name']] = $artist['artist']['sort-name'];
            } else {
                $this->mainBands[$artist['artist']['name']] = $artist['artist']['name'];
            }
        }
    }

    private function setPublisher(array $labels): void
    {
        if (isset($this->publisher)) {
            return;
        }
        foreach ($labels as $label) {
            if (isset($label['label']['id'])) {
                if (($label['label']['type'] ?? '') != 'Imprint') {
                    $this->publisher = $label['label']['name'];
                    break;
                }
            }
        }
    }

    private function setDurationAndAddRecordingTags(array $medias): void
    {
        $duration = 0;

        foreach ($medias as $media) {
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
    }

    private function addTags(array $tags): void
    {
        foreach ($tags ?? [] as $tag) {
            if (isset($tag['name'])) {
                $this->tags[$tag['name']] = $tag['name'];
            }
        }
    }

}
