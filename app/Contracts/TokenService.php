<?php

namespace App\Contracts;

interface TokenService
{
    public function createToken(): string;
}
