<?php

namespace Database\Factories;

use App\Models\FeedBack;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "body"=>$this->faker->text(20),
            "user_id"=>$this->faker->randomElement(User::pluck('id')->toArray()),
            "feedback_id"=>$this->faker->randomElement(FeedBack::pluck('id')->toArray())
        ];
    }
}
