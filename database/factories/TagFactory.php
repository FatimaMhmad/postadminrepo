<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    public function definition()
    {
        return 
        [
            'title' => fake()->unique()->name()
        ];
    }
}
