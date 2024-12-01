<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('books')->insert([
            ['name' => 'The Enchanted Forest', 'description' => 'A whimsical tale of adventure and magic in a forest full of mythical creatures.'], 
            ['name' => 'Journey to the Stars', 'description' => 'An epic science fiction novel about humanity\'s first interstellar voyage.'], 
            ['name' => 'Mystery of the Old Mansion', 'description' => 'A gripping mystery novel set in a spooky, abandoned mansion.'],
            ['name' => 'The Art of Mindfulness', 'description' => 'A guide to incorporating mindfulness into everyday life for greater peace and clarity.'], 
            ['name' => 'Cooking with Love', 'description' => 'A collection of delicious recipes and heartfelt stories from a seasoned chef.'], 
            ['name' => 'The Rise of the Phoenix', 'description' => 'A thrilling fantasy novel about a young hero\'s journey to reclaim a lost kingdom.'], 
            ['name' => 'History\'s Greatest Inventions', 'description' => 'An insightful look at the inventions that changed the world throughout history.'], 
            ['name' => 'A Walk Through Paris', 'description' => 'A romantic novel following a couple\'s journey through the enchanting streets of Paris.'], 
            ['name' => 'Gardening for Beginners', 'description' => 'A practical guide for new gardeners looking to cultivate their green thumb.'], 
            ['name' => 'Tales from the Sea', 'description' => 'A collection of captivating stories inspired by the mysteries of the ocean.'],
        ]);
    }
}
