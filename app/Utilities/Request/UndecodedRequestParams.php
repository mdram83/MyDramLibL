<?php

namespace App\Utilities\Request;

use Illuminate\Http\Request;

class UndecodedRequestParams implements UndecodedRequestParamsInterface
{
    private Request $request;
    private array $queryParams;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->queryParams = $this->prepareUndecodedQueryParams();
    }

    private function prepareUndecodedQueryParams(): array
    {
        if (!($rawQueryString = $this->request->server->get('QUERY_STRING'))) {
            return [];
        }
        $queryParams = [];

        foreach (explode('&', $rawQueryString) as $element) {
            [$key, $value] = explode('=', $element);
            $queryParams[$key] = $value;
        }

        return $queryParams;
    }

    public function query(): array
    {
        return $this->queryParams;
    }

    public function get(string $paramName): ?string
    {
        return $this->queryParams[$paramName] ?? null;
    }
}
