<?php

namespace App\Utilities\API\EAN;

use App\Utilities\API\RestAPIHandler;

interface EANMusicRestAPI extends RestAPIHandler
{
    public function getParsedContent() : array;
}
