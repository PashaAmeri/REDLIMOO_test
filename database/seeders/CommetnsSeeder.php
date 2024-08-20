<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory;

class CommetnsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Factory::create();

        for ($i = 0; $i < 200; $i++) {
            Comment::create([
                'user_id' => 1,
                'post_id' => rand(1, 50),
                'content' => $faker->paragraphs(rand(2, 8), true),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        for ($i = 0; $i < 200; $i++) {
            Comment::create([
                'user_id' => 1,
                'post_id' => rand(1, 50),
                'parent_id' => rand(1, 200),
                'content' => $faker->paragraphs(rand(2, 8), true),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
