<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedBackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title"=> $this->faker->unique()->text(13),
            "description"=> $this->faker->unique()->text(200),
            "image"=> $this->faker->imageUrl(640,480),
            "user_id" => $this->faker->randomElement(User::pluck('id')->toArray()),
            "category_id" => $this->faker->randomElement(Category::pluck('id')->toArray()),
        ];
    }
}
