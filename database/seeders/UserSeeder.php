<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('jelszo123');

        DB::table('user')->insert([
            ['email' => 'admin@kukta.hu', 'name' => 'kukta', 'password' => $password, 'is_admin' => true],
            ['email' => 'nagy.anna@gmail.com', 'name' => 'nagyanna', 'password' => $password, 'is_admin' => false],
            ['email' => 'molnar.era@gmail.com', 'name' => 'molnarera', 'password' => $password, 'is_admin' => false],
            ['email' => 'balogh.peter@gmail.com', 'name' => 'baloghpeter', 'password' => $password,
                'is_admin' => false],
            ['email' => 'varga.zsofia@gmail.com', 'name' => 'vargazsofia', 'password' => $password,
                'is_admin' => false],
        ]);
    }
}
