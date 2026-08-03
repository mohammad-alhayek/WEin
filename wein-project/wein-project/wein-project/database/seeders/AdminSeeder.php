<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name'          => 'Admin',
            'email'         => 'admin@wein.com',
            'password_hash' => Hash::make('password'),
        ]);

        $this->command->info('Admin created: admin@wein.com / password');
    }
}
