<?php

namespace App\Utilities\API\ISBN;

use App\Utilities\API\RestAPIHandler;

interface ISBNRestAPI extends RestAPIHandler
{
    public function getParsedContent() : array;
}
