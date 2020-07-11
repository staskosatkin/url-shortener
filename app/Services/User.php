<?php

namespace App\Services;

use App\Contracts\TokenService;
use App\Contracts\UserService;
use App\User as UserModel;

class User implements UserService
{
    private TokenService $tokenService;

    /**
     * User constructor.
     * @param TokenService $tokenService
     */
    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @param string $name
     */
    public function refreshTokenByUsername(string $name): void
    {
        /** @var UserModel $user */
        $user = UserModel::where("name", $name)->firstOrFail();
        $user->api_token = $this->tokenService->createToken();
        $user->save();
    }
}
