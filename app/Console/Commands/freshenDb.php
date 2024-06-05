<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class freshenDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:freshen-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Freshen the DB and optionally seed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('migrate:fresh');

        $register = $this->ask('Do you wish to register a user? [y/n]');

        if ($register === 'y' || $register === 'Y') {
            $this->call('app:register');
        }

        $seed = $this->ask('Do you wish to seed the DB? [y/n]');

        if ($seed === 'y' || $seed === 'Y') {
            $this->call('db:seed');
        }
    }
}
