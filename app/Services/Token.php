<?php

namespace App\Services;

use App\Contracts\TokenService;
use Illuminate\Support\Str;

class Token implements TokenService
{
    public function createToken(): string
    {
        return hash('sha256', Str::random(60));
    }
}
