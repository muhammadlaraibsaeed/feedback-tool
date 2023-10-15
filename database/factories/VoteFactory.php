<?php

namespace Database\Factories;

use App\Models\FeedBack;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

class VoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $vote = Vote::whereIn('value',[1,2])
        ->where('feedback_id',$this->faker->randomElement(FeedBack::pluck('id')->toArray()))
        ->where('user_id',$this->faker->randomElement(User::pluck('id')->toArray()))
        ->exists();

        if(empty($vote)){
            return [
                "value"=> $this->faker->randomElement(['1','2']),
                "user_id"=> $this->faker->randomElement(User::pluck('id')->toArray()),
                "feedback_id"=> $this->faker->randomElement(FeedBack::pluck('id')->toArray()),
            ];
        }else{
            Log::info("Vote Is empty " .$vote);
        }

    }
}
