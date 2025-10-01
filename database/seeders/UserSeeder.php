<?php

namespace Database\Seeders;

use App\Constants\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'role'     => Role::ADMIN_ROLE,
            'username' => 'admin',
            'email'    => 'admin@example.com',
            'phone'    => '01743776488',
            'password' => 12345678,
        ]);

        User::updateOrCreate([
            'role'     => Role::USER_ROLE,
            'username' => 'user',
            'email'    => 'user@example.com',
            'phone'    => '01602603147',
            'password' => 12345678,
        ]);
    }
}
