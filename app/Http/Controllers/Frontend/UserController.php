<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Vote;
use App\Models\FeedBack;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function view()
    {
        $feedBacks = FeedBack::withCount('votes')
        ->with('votes')
        ->get();
        $co_votes = Vote::where('user_id',Auth::user()->id)->get();

        return view('frontend.user.profile',compact('feedBacks','co_votes'));
    }
}
