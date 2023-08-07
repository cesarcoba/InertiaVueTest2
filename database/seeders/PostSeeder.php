<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        dump("en el seeder");
        //Post::factory()->count(30);
        Post::factory(10)->create([
            'title' => fake()->name(),
            'content' => fake()->text(50)
        ]);
        dump("despues del seeder");
    }
}
