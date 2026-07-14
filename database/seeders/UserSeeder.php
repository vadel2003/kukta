<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'email' => 'teszt@example.com',
            'username' => 'tesztuser',
            'password' => Hash::make('password123'),
            'role' => 1,
            'firstname' => 'Teszt',
            'lastname' => 'Elek',
        ]);
    }
}

