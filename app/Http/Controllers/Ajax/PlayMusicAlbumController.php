<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Utilities\API\Spotify\SpotifyRestAPI;
use App\Utilities\API\Spotify\SpotifyRestAPIAuthorization;
use Exception;
use GuzzleHttp\Client;

class PlayMusicAlbumController extends Controller
{
    protected ?string $ean;
    protected string $title;
    protected array $artists;
    protected SpotifyRestAPIAuthorization $authorization;

    public function show(int $id)
    {
        $this->loadMusicAlbumParams($id);
        $this->authorization = new SpotifyRestAPIAuthorization();

        if (isset($this->ean)) {

            try {
                $spotifyApi = new SpotifyRestAPI(new Client(), $this->authorization);
                $spotifyApi->setEAN($this->ean);
                $spotifyApi->send();

                if ($spotifyApi->getResponseCode() == 200) {
                    return response()->json($spotifyApi->getParsedContent());
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
                    return response()->json($spotifyApi->getParsedContent());
                }

            } catch (Exception) {
            }
        }

        try {
            $spotifyApi = new SpotifyRestAPI(new Client(), $this->authorization);
            $spotifyApi->setTitleAndArtist($this->title);
            $spotifyApi->send();

            if ($spotifyApi->getResponseCode() == 200) {
                return response()->json($spotifyApi->getParsedContent());
            }

        } catch (Exception) {
        }

        return response()->json(null, 404);
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
