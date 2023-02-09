<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\MusicAlbum;
use App\Utilities\API\Spotify\SpotifyRestAPI;
use App\Utilities\API\Spotify\SpotifyRestAPIAuthorization;
use App\Utilities\API\YouTube\YouTubeRestAPI;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;

class PlayMusicAlbumController extends Controller
{
    protected ?string $ean;
    protected string $title;
    protected array $artists;
    protected SpotifyRestAPIAuthorization $authorization;

    protected array $links = [];
    protected MusicAlbum $musicAlbum;

    public function show(int $id)
    {
        $this->loadMusicAlbumParams($id);

        if ($this->links === []) {

            $this->generateSpotifyLink();
            $this->generateYouTubeLink();

            if ($this->links === []) {
                return response()->json(null, 404);
            }

            try {
                $this->setMusicAlbumLinksUnsaved($this->links);
            } catch (Exception) {
                return $this->returnServerError();
            }

        }

        try {
            $this->updateMusicAlbumPlayCount();
        } catch (Exception) {
            return $this->returnServerError();
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
        $this->musicAlbum = auth()->user()->musicAlbums()->where('music_albums.id', $musicAlbumId)->firstOrFail();

        $this->ean = $this->musicAlbum->ean;
        $this->title = $this->musicAlbum->item->title;

        $this->artists = array_merge(
            $this->musicAlbum->item->mainArtists
                ->map(fn($item) => trim($item->firstname . ' ' . $item->lastname))
                ->toArray(),
            $this->musicAlbum->item->mainBands
                ->map(fn($item) => $item->name)
                ->toArray()
        );

        $this->links = $this->musicAlbum->links == null ? [] : unserialize($this->musicAlbum->links);
    }

    protected function setMusicAlbumLinksUnsaved(array $links): void
    {
        $this->musicAlbum->links = serialize($links);
    }

    protected function updateMusicAlbumPlayCount(): void
    {
        $this->musicAlbum->play_count++;
        $this->musicAlbum->played_on = now();
        $this->musicAlbum->save();
    }

    protected function returnServerError(): JsonResponse
    {
        return response()->json([], 500);
    }


}
