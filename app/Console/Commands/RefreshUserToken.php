<?php

namespace App\Console\Commands;

use App\Contracts\UserService;
use Illuminate\Console\Command;

class RefreshUserToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:token:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh User Token';

    private UserService $userService;

    /**
     * Create a new command instance.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->ask("Name");

        $this->userService->refreshTokenByUsername($name);

        $this->info("Hash refreshed");
    }
}
