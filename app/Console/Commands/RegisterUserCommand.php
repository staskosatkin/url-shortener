<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class RegisterUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'register:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register User';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $details = $this->getDetails();

        $user = new User($details);
        $user->save();

        $this->display($user);
    }

    /**
     * Ask for user details.
     *
     * @return array
     */
    private function getDetails(): array
    {
        $details['name'] = $this->ask('Name');
        $details['email'] = $this->ask('Email');
        $details['password'] = (string) $this->secret('Password');
        $details['confirm_password'] = (string) $this->secret('Confirm password');

        while (!$this->isValidPassword($details['password'], $details['confirm_password'])) {
            if (!$this->isRequiredLength($details['password'])) {
                $this->error('Password must be more that six characters');
            }

            if (!$this->isMatch($details['password'], $details['confirm_password'])) {
                $this->error('Password and Confirm password do not match');
            }

            $details['password'] = (string) $this->secret('Password');
            $details['confirm_password'] = (string) $this->secret('Confirm password');
        }

        return $details;
    }

    /**
     * Display created user.
     *
     * @param User $user
     * @return void
     */
    private function display(User $user) : void
    {
        $headers = ['Name', 'Email'];

        $fields = [
            'Name' => $user->name,
            'email' => $user->email,
        ];

        $this->info('User created');
        $this->table($headers, [$fields]);
    }

    /**
     * Check if password is valid
     *
     * @param string $password
     * @param string $confirmPassword
     * @return boolean
     */
    private function isValidPassword(string $password, string $confirmPassword) : bool
    {
        return $this->isRequiredLength($password) &&
            $this->isMatch($password, $confirmPassword);
    }

    /**
     * Check if password and confirm password matches.
     *
     * @param string $password
     * @param string $confirmPassword
     * @return bool
     */
    private function isMatch(string $password, string $confirmPassword) : bool
    {
        return $password === $confirmPassword;
    }

    /**
     * Checks if password is longer than six characters.
     *
     * @param string $password
     * @param int $length
     * @return bool
     */
    private function isRequiredLength(string $password, int $length = 6) : bool
    {
        return strlen($password) > $length;
    }
}
