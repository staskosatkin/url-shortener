<?php

namespace App\Services;

use App\Contracts\HashGenerationService;
use Illuminate\Support\Str;

class HashRandomString implements HashGenerationService
{
    public function createHash(): string
    {
        $hash = hash('sha256', Str::random(60));
        $base64 = base64_encode($hash);
        return Str::substr($base64, 0, 6);
    }
}
