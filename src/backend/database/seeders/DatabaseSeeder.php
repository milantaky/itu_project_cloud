<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Účet 1: l@c
        DB::table('User')->updateOrInsert(
            ['user_email' => 'l@c'],
            [
                'user_firstname' => 'Lukáš',
                'user_lastname' => 'Černý',
                'user_password' => Hash::make('123456'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Účet 2: f@v
        DB::table('User')->updateOrInsert(
            ['user_email' => 'f@v'],
            [
                'user_firstname' => 'Filip',
                'user_lastname' => 'Veselý',
                'user_password' => Hash::make('123456'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}