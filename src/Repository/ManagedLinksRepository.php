<?php

namespace App\Repository;

use Error;
use Exception;

class ManagedLinksRepository
{
    private string $apiUrl;
    private string $apiToken;

    public function __construct()
    {
        $config = json_decode(file_get_contents(
            __DIR__
                .  DIRECTORY_SEPARATOR
                . '..'
                 . DIRECTORY_SEPARATOR
                . '..'
                 . DIRECTORY_SEPARATOR
                . '.env.json'
        ), true);

        $apiUrl = $config['managedLinksApiUri'] ?? null;

        if (! $apiUrl) {
            throw new Exception('Missing API URL');
        }

        $apiToken = $config['managedLinksApiToken'] ?? null;

        if (! $apiToken) {
            throw new Exception('Missing API Token');
        }

        $this->apiUrl = $apiUrl;
        $this->apiToken = $apiToken;
    }

    public function findUserProfile(string $userSlug): ?string
    {
        $domain = $_SERVER['HTTP_HOST'] ?? null;

        if (! $domain) {
            throw new Exception('Empty $_SERVER[\'HTTP_HOST\']');
        }

        $curlRequest = curl_init($this->apiUrl . '/api/url-shortener/' . $userSlug . '?domain=' . $domain);
        curl_setopt_array($curlRequest, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->apiToken
            ]
        ]);

        $curlResponse = curl_exec($curlRequest);
        curl_close($curlRequest);

        $httpCode = curl_getinfo($curlRequest, CURLINFO_HTTP_CODE);

        if ($httpCode === 200) {
            return $curlResponse;
        }

        if ($httpCode === 404) {
            return null;
        }

        throw new Error($curlResponse);
    }
}
