<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'last_name' => '田中',
                'first_name' => '太郎',
                'email' => 'test@test.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                'created_at' => now(),
            ],
            [
                'last_name' => '山田',
                'first_name' => '花子',
                'email' => 'yamada@test.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                'created_at' => now(),
            ],
        ]);
    }
}
