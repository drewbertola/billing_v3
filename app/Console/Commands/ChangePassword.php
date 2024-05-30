<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature =  'app:change-password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update password for a user.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $success = true;

        $email = $this->ask('What is the email of the user?');
        $password = $this->secret('What is the new password for the user?');

        $user = User::where('email', $email)->first();

        if (empty($user->id)) {
            $this->error('The user with that email could not be found in the database.');
            $success = false;
        }

        if ($success) {
            try {
                $user->update([
                    'password' => Hash::make($password),
                ]);
            } catch (\Exception $e) {
                $success = false;
                $this->error('Something went wrong.  Please check the logs.');
            }
        }

        if ($success) {
            $this->info('The password was updated!');
        }
    }
}
