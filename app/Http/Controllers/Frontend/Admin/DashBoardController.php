<?php

namespace App\Http\Controllers\Frontend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\FeedBack;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DashBoardController extends Controller
{
    public function dashBoard()
    {
         $categories = Category::all();
         $comments = Comment::with('feedback')->get();
         $feedbacks = FeedBack::all();

        return view('backend.dashboard',compact('categories','comments','feedbacks'));
    }
}
