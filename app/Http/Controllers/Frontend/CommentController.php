<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function showComment(Request $request)
    {
        if($request->ajax())
        {
            $comments = Comment::latest()
                                    ->where('feedback_id',$request->feedback_id)
                                    ->get();
            return view('frontend.comments.comments',compact('comments'));
        }
    }

    public function voteShow(Request $request)
    {
        if($request->ajax()){
            return view('frontend.comments.votelists');
        }
    }
}
