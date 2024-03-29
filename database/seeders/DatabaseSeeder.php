<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vote;
use App\Models\Comment;
use App\Models\Category;
use App\Models\FeedBack;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        Category::factory(10)->create();
        FeedBack::factory(30)->create();
        Comment::factory(150)->create();
        Vote::factory(120)->create();
    }
}
