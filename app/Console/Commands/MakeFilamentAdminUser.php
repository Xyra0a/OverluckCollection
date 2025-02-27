<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MakeFilamentAdminUser extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:filament-admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Filament admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Enter the name of the admin');
        $email = $this->ask('Enter the email of the admin');
        $password = $this->secret('Enter the password of the admin');

        Admin::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('Admin user created successfully!');
    }
}
