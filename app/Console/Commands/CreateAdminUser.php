<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = new User;
        $user->username = 'Test';
        $user->name = 'Test';
        $user->email = 'case.alvarado.au@phinmaed.com';
        $user->contact = '09183077562';
        $user->password = bcrypt('password123');
        $user->role = 'owner';
        $user->save();

        $this->info('Admin user created successfully!');
    }
}
