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
            ['email' => 'admin@kukta.hu',          'name' => 'kukta',          'password' => $password, 'is_admin' => true],
            ['email' => 'nagy.anna@gmail.com',      'name' => 'nagyanna',      'password' => $password, 'is_admin' => false],
            ['email' => 'kovacs.bela@gmail.com',    'name' => 'kovacsbela',    'password' => $password, 'is_admin' => false],
            ['email' => 'szabo.csilla@gmail.com',   'name' => 'szabocsilla',   'password' => $password, 'is_admin' => false],
            ['email' => 'toth.daniel@gmail.com',    'name' => 'tothdaniel',    'password' => $password, 'is_admin' => false],
            ['email' => 'molnar.era@gmail.com',     'name' => 'molnarera',     'password' => $password, 'is_admin' => false],
            ['email' => 'kiss.tamas@gmail.com',     'name' => 'kisstamas',     'password' => $password, 'is_admin' => false],
            ['email' => 'feher.judit@gmail.com',    'name' => 'feherjudit',    'password' => $password, 'is_admin' => false],
            ['email' => 'balogh.peter@gmail.com',   'name' => 'baloghpetter',  'password' => $password, 'is_admin' => false],
            ['email' => 'varga.zsofia@gmail.com',   'name' => 'vargazsofia',   'password' => $password, 'is_admin' => false],
        ];

        DB::table('user')->insert($users);
    }
}