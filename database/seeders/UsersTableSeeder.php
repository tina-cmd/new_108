<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Librarian',
                'username' => 'postgres',
                'password' => bcrypt('admin'), // Always hash passwords
                'role' => 'librarian',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Assistant',
                'username' => 'assistant',
                'password' => bcrypt('assistant'),
                'role' => 'assistant',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dodong',
                'username' => 'dodong',
                'password' => bcrypt('dodong'), // Always hash passwords
                'role' => 'member',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
