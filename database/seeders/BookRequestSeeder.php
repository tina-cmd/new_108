<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('book_requests')->insert([
            ['inventory_id' => 2, 'user_id' => 3, 'qty' => 1, 'requested_at' => Carbon::now()],
            ['inventory_id' => 3, 'user_id' => 3, 'qty' => 1, 'requested_at' => Carbon::now()],
        ]);
    }
}
