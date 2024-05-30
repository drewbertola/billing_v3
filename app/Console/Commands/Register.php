<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class Register extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature =  'app:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Registier blog user with full privileges.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $success = true;

        $name = $this->ask('What is the name of the user?');
        $email = $this->ask('What is the email of the user?');
        $password = $this->secret('What is the password for the user?');

        $user = User::where('email', $email)->first();

        if (! empty($user->id)) {
            $this->error('That email already exists in the database.');
            $success = false;
        }

        if ($success) {
            try {
                User::create([
                    'name' => $name,
                    'email' => strtolower($email),
                    'password' => Hash::make($password),
                ]);
            } catch (\Exception $e) {
                $success = false;
                $this->error('Something went wrong.  Please check the logs.');
            }
        }

        if ($success) {
            $this->info('The user was registered!');
        }
    }
}
