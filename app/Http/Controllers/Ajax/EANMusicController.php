<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Utilities\API\EAN\MusicBrainzEANMusicRestAPI;
use App\Utilities\API\EAN\EANMusicRestAPI;
use Illuminate\Http\Request;

class EANMusicController extends Controller
{
    public function __construct(private EANMusicRestAPI $musicRestAPI)
    {

    }

    public function show(string $ean)
    {

        // TODO validation goes here and cut dashes etc.


        $this->musicRestAPI->setEAN($ean);
        dd([
            'responseCode' => $this->musicRestAPI->getResponseCode(),
            'parsed Content' => $this->musicRestAPI->getParsedContent(),
        ]);

        return response()->json($this->musicRestAPI->getParsedContent(), 200);
    }
}
