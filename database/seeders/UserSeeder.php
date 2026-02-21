<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = \App\Models\Role::where('name', 'Admin')->first();

        \App\Models\User::updateOrCreate(
            ['email' => 'admin@tuition.com'],
            [
                'name' => 'Admin User',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role_id' => $adminRole->id,
                'phone' => '1234567890',
            ]
        );
    }
}
