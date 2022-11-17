<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Rules\ISBN;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;

class ISBNOpenlibraryController extends Controller
{
    public function show(string $isbn)
    {
        $isbn = str_replace('-', '', $isbn);

        $validator = Validator::make(['isbn' => $isbn], [
            'isbn' => ['required', new ISBN()],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        try {
            // TODO in constructor and using interface
            $apiHandler = new \App\Utilities\API\ISBNOpenlibrary(new Client(), $isbn);
            if ($apiHandler->getResponseCode() == 200) {

                return response()->json(
                    $this->parseISBNOpenlibraryDetails($isbn, $apiHandler->getResponseContent())
                );

            }
        } catch (Exception) {
        }

        return response()->json(null, 404);

    }

    // TODO: not te right class for this method?
    private function parseISBNOpenlibraryDetails(string $isbn, string $responseContent): array
    {
        $responseArray = json_decode($responseContent, true);
        $responseArray = $responseArray["ISBN:$isbn"]['details'];
        $details = [
            'title' => $responseArray['title'] ?? null,
            'authorFirstname' => null,
            'authorLastname' => null,
            'isbn' => $isbn,
            'publisher' => $responseArray['publishers'][0] ?? null,
            'series' => null,
            'volume' => null,
            'pages' => $responseArray['number_of_pages'] ?? null,
            'tags' => $responseArray['subjects'] ?? [],
        ];

        // TODO adjust to many authors
        $author = $responseArray['authors'][0]['name'] ?? null;
        if ($author) {
            $splitPosition = strrpos($author, ' ');
            $details['authorFirstname'] = trim(substr($author, 0, $splitPosition));
            $details['authorLastname'] = trim(substr($author, $splitPosition));
        }

        $series = $responseArray['series'][0] ?? null;
        if ($series) {
            $splitPosition = strrpos($series, ', #');
            $details['series'] = ($splitPosition !== false) ? trim(substr($series, 0, $splitPosition)) : trim($series);
            $details['volume'] = ($splitPosition !== false) ? trim(substr($series, $splitPosition + 3)) : null;
        }

        return $details;
    }
}
