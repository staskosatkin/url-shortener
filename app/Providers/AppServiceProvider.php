<?php

namespace App\Providers;

use App\Contracts\HashGenerationService;
use App\Contracts\TokenService;
use App\Contracts\UrlService;
use App\Contracts\UserService;
use App\Services\HashRandomString;
use App\Services\Token;
use App\Services\Url;
use App\Services\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UrlService::class, Url::class);
        $this->app->bind(TokenService::class, Token::class);
        $this->app->bind(UserService::class, User::class);
        $this->app->bind(HashGenerationService::class, HashRandomString::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
