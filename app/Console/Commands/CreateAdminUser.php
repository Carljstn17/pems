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
        $user->name = 'Admin';
        $user->email = 'admin@example.com';
        $user->password = bcrypt('admin123');
        $user->role = 'admin';
        $user->save();

        $this->info('Admin user created successfully!');
    }
}
