<?php

namespace App\Utilities\API\Spotify;

use App\Utilities\API\RestAPIHandlerGuzzle;

class SpotifyRestAPIAuthorization
{
    protected array $headers;
    protected array $requestParams = ['form_params' => ['grant_type' => 'client_credentials']];
    protected string $tokenUri = 'https://accounts.spotify.com/api/token';
    protected string $tokenMethod = 'POST';

    protected bool $sent = false;
    protected array $token;

    public function __construct()
    {
        $this->headers = [
            'Authorization' => 'Basic ' . base64_encode(
                config('services.spotify.api.client_id') . ':' . config('services.spotify.api.client_secret')
            ),
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];
    }

    public function getAccessToken(): string
    {
        $this->send();
        return $this->token['access_token'];
    }

    public function getTokenType(): string
    {
        $this->send();
        return $this->token['token_type'];
    }

    protected function send(): void
    {
        if ($this->sent) {
            return;
        }

        $api = new RestAPIHandlerGuzzle(
            $this->headers,
            $this->tokenUri,
            $this->tokenMethod,
            $this->requestParams
        );

        $api->send();

        $this->token = json_decode($api->getResponseContent(), true);
        $this->sent = true;
    }
}
