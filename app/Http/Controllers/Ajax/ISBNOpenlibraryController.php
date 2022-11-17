<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Rules\ISBN;
use App\Utilities\API\ISBN\ISBNRestAPI;
use Exception;
use Illuminate\Support\Facades\Validator;

class ISBNOpenlibraryController extends Controller
{
    public function show(ISBNRestAPI $isbnRestApi, string $isbn)
    {
        $isbn = str_replace('-', '', $isbn);

        $validator = Validator::make(['isbn' => $isbn], [
            'isbn' => ['required', new ISBN()],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        try {
            $isbnRestApi->setISBN($isbn);
            if ($isbnRestApi->getResponseCode() == 200) {

                return response()->json($isbnRestApi->getParsedContent());

            }
        } catch (Exception) {
        }
        return response()->json(null, 404);
    }
}
