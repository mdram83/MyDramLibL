<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Artist;

class ArtistController extends Controller
{
    public function index()
    {
        $data = [];
        foreach (Artist::orderBy('lastname')->orderBy('firstname')->get(['id', 'firstname', 'lastname']) as $artist) {
            $firstname = $artist->firstname;
            $lastname = $artist->lastname;

            $data['artists'][$artist->id]['name'] = $artist->getName();
            $data['artists'][$artist->id]['firstname'] = $firstname;
            $data['artists'][$artist->id]['lastname'] = $lastname;

            if ($firstname !== '') {
                $data['firstnames'][$firstname] = $firstname;
            }
            $data['lastnames'][$lastname] = $lastname;
        }
        sort($data['firstnames']);
        sort($data['lastnames']);

        return response()->json($data);
    }
}
