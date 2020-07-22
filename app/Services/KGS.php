<?php

namespace App\Services;

use App\Contracts\HashGenerationService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class KGS implements HashGenerationService
{
    /**
     * @return string
     */
    public function createHash(): string
    {
        $client = new Client([
            'base_uri'        => 'http://docker.for.mac.localhost:8082/',
//            'base_uri'        => 'http://127.0.0.1:8082/',
        ]);

        $start = microtime(true);
        $hash = $client->post('/api/fetch')->getBody()->getContents();
        $duration = round((microtime(true) - $start) * 1000, 2);
        Log::debug("Request to KGS takes [$duration] ms");
        return $hash;
    }
}
