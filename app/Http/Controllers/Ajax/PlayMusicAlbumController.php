<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Rules\EAN;
use App\Utilities\API\Spotify\SpotifyRestAPI;
use Exception;
use Illuminate\Support\Facades\Validator;

class PlayMusicAlbumController extends Controller
{
    public function show(SpotifyRestAPI $spotifyApi, string $ean)
    {
        $ean = str_replace('-', '', $ean);

        $validator = Validator::make(['ean' => $ean], [
            'ean' => ['required', new EAN()],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        try {

            $spotifyApi->setEAN($ean);
            $spotifyApi->send();

            if ($spotifyApi->getResponseCode() == 200) {
                return response()->json($spotifyApi->getParsedContent());
            }

        } catch (Exception) {
        }

        return response()->json(null, 404);
    }
}
