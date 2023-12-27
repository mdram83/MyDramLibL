<?php

namespace App\Utilities\Request;

interface UndecodedRequestParamsInterface
{
    public function query(): array;
    public function get(string $paramName): ?string;
}
