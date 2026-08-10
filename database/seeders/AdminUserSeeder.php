<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the initial admin account.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@kaundasquare.local'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'must_change_password' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
