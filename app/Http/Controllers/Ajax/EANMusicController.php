<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Rules\EAN;
use App\Utilities\API\EAN\EANMusicRestAPI;
use Exception;
use Illuminate\Support\Facades\Validator;

class EANMusicController extends Controller
{

    public function show(EANMusicRestAPI $musicRestAPI, string $ean)
    {

        $ean = str_replace('-', '', $ean);

        $validator = Validator::make(['ean' => $ean], [
            'ean' => ['required', new EAN()],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        try {

            $musicRestAPI->setEAN($ean);
            $musicRestAPI->send();

            if ($musicRestAPI->getResponseCode() == 200) {
                return response()->json($musicRestAPI->getParsedContent(), 200);
            }

        } catch (Exception) {
        }

        return response()->json(null, 404);
    }
}
