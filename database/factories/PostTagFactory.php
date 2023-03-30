<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostTagFactory extends Factory
{
    public function definition()
    {
        return 
        [
            'post_id' => Post::inRandomOrder()->first()->id,
            'tag_id'  => Tag::inRandomOrder()->first()->id,
        ];
    }
}
