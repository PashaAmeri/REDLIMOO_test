<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Factory::create();

        for ($i = 0; $i < 50; $i++) {
            Post::create([
                'user_id' => 1,
                'title' => $faker->sentence,
                'content' => $faker->paragraphs(rand(2, 15), true),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
