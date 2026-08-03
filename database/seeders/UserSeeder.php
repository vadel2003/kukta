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

        $users = [
            ['email' => 'admin@kukta.hu',          'name' => 'admin',          'password' => $password, 'role' => 1],
            ['email' => 'nagy.anna@gmail.com',      'name' => 'nagyanna',      'password' => $password, 'role' => 0],
            ['email' => 'kovacs.bela@gmail.com',    'name' => 'kovacsbela',    'password' => $password, 'role' => 0],
            ['email' => 'szabo.csilla@gmail.com',   'name' => 'szabocsilla',   'password' => $password, 'role' => 0],
            ['email' => 'toth.daniel@gmail.com',    'name' => 'tothdaniel',    'password' => $password, 'role' => 0],
            ['email' => 'molnar.era@gmail.com',     'name' => 'molnarera',     'password' => $password, 'role' => 0],
            ['email' => 'kiss.tamas@gmail.com',     'name' => 'kisstamas',     'password' => $password, 'role' => 0],
            ['email' => 'feher.judit@gmail.com',    'name' => 'feherjudit',    'password' => $password, 'role' => 0],
            ['email' => 'balogh.peter@gmail.com',   'name' => 'baloghpetter',  'password' => $password, 'role' => 0],
            ['email' => 'varga.zsofia@gmail.com',   'name' => 'vargazsofia',   'password' => $password, 'role' => 0],
        ];

        DB::table('user')->insert($users);
    }
}