<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition()
    {
        return
        [
            'title'                => fake()->name(),
            'body'                 => fake()->text(),
            'date_of_publication'  => fake()->dateTime(),
            'category_id'          => Category::inRandomOrder()->first()->id,
            'user_id'              => User::inRandomOrder()->first()->id,
        ];
    }
}
