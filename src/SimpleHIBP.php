<?php

namespace HIBP;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class SimpleHIBP
{
    const API_ENDPOINT = 'https://api.pwnedpasswords.com/range/';
    const HASH = 'sha1';

    private static $client = null;

    public static function isPasswordSafe(string $password): bool
    {
        if (preg_match('/([A-Z0-9]{5})([A-Z0-9]+)/u', strtoupper(hash(self::HASH, $password)), $matches)) {
            $password = null;
            $prefix = $matches[1];
            $suffix = $matches[2];

            if (is_null(self::$client)) {
                self::$client = new Client([
                    'base_uri' => self::API_ENDPOINT
                ]);
            }

            try {
                $response = self::$client->get($prefix);
            } catch (RequestException $e) {
                return true;
            }

            if (preg_match('/'.preg_quote($suffix).':[0-9]+/u', (string)$response->getBody())) {
                return false;
            }

            return true;
        }
    }
}
