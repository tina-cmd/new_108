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
            ['book_id' => 2, 'qty' => 10, 'created_at' => Carbon::now()],
            ['book_id' => 3, 'qty' => 20, 'created_at' => Carbon::now()],
            ['book_id' => 4, 'qty' => 30, 'created_at' => Carbon::now()],
            ['book_id' => 5, 'qty' => 10, 'created_at' => Carbon::now()],
            ['book_id' => 6, 'qty' => 20, 'created_at' => Carbon::now()],
            ['book_id' => 7, 'qty' => 30, 'created_at' => Carbon::now()],
            ['book_id' => 8, 'qty' => 10, 'created_at' => Carbon::now()],
            ['book_id' => 9, 'qty' => 20, 'created_at' => Carbon::now()],
            ['book_id' => 10, 'qty' => 30, 'created_at' => Carbon::now()],
        ]);
    }
}
