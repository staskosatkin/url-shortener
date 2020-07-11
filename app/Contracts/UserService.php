<?php

namespace App\Contracts;

interface UserService
{
    public function refreshTokenByUsername(string $name): void;
}
