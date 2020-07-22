<?php

namespace App\Services;

use App\Contracts\HashGenerationService;
use Illuminate\Support\Str;

class HashRandomString implements HashGenerationService
{
    public function createHash(): string
    {
        return Str::random(6);
    }
}
