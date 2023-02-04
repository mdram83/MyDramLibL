<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Utilities\API\Spotify\SpotifyRestAPI;
use App\Utilities\API\Spotify\SpotifyRestAPIAuthorization;
use App\Utilities\API\YouTube\YouTubeRestAPI;
use Exception;
use GuzzleHttp\Client;

class PlayMusicAlbumController extends Controller
{
    protected ?string $ean;
    protected string $title;
    protected array $artists;
    protected SpotifyRestAPIAuthorization $authorization;

    protected array $links = [];

    public function show(int $id)
    {
        $this->loadMusicAlbumParams($id);
        $this->generateSpotifyLink();
        $this->generateYouTubeLink();

        if ($this->links === []) {
            return response()->json(null, 404);
        }

        return response()->json($this->links);


    }

    protected function generateSpotifyLink(): void
    {
        $this->authorization = new SpotifyRestAPIAuthorization();

        if (isset($this->ean)) {

            try {
                $spotifyApi = new SpotifyRestAPI(new Client(), $this->authorization);
                $spotifyApi->setEAN($this->ean);
                $spotifyApi->send();

                if ($spotifyApi->getResponseCode() == 200) {
                    $this->links['spotify_web_link'] = $spotifyApi->getParsedContent()['spotify_web_link'];
                    return;
                }

            } catch (Exception) {
            }
        }

        foreach($this->artists as $artist) {

            try {
                $spotifyApi = new SpotifyRestAPI(new Client(), $this->authorization);
                $spotifyApi->setTitleAndArtist($this->title, $artist);
                $spotifyApi->send();

                if ($spotifyApi->getResponseCode() == 200) {
                    $this->links['spotify_web_link'] = $spotifyApi->getParsedContent()['spotify_web_link'];
                    return;
                }

            } catch (Exception) {
            }
        }

        try {
            $spotifyApi = new SpotifyRestAPI(new Client(), $this->authorization);
            $spotifyApi->setTitleAndArtist($this->title);
            $spotifyApi->send();

            if ($spotifyApi->getResponseCode() == 200) {
                $this->links['spotify_web_link'] = $spotifyApi->getParsedContent()['spotify_web_link'];
                return;
            }

        } catch (Exception) {
        }
    }

    protected function generateYouTubeLink(): void
    {
        try {
            $youtubeApi = new YouTubeRestAPI(new Client());
            $youtubeApi->setTitleAndArtist($this->title, $this->artists[0] ?? null);
            $youtubeApi->send();

            if ($youtubeApi->getResponseCode() == 200) {
                $this->links['youtube_link'] = $youtubeApi->getParsedContent()['link'];
            }

        } catch (Exception) {
        }
    }



    protected function loadMusicAlbumParams(int $musicAlbumId): void
    {
        $musicAlbum = auth()->user()->musicAlbums()->where('music_albums.id', $musicAlbumId)->firstOrFail();

        $this->ean = $musicAlbum->ean;
        $this->title = $musicAlbum->item->title;

        $this->artists = array_merge(
            $musicAlbum->item->mainArtists
                ->map(fn($item) => trim($item->firstname . ' ' . $item->lastname))
                ->toArray(),
            $musicAlbum->item->mainBands
                ->map(fn($item) => $item->name)
                ->toArray()
        );
    }
}
