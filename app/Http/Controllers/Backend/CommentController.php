<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\CommentMail;
use App\Models\Comment;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    use HelperTrait;
    public function storeComment(Request $request)
    {
        $comment = $request->all();
        $comment['user_id'] = Auth::user()->id;
        $comment = Comment::create($comment);
       // For send mail  who create feedback
        $this->sendCommentMail($comment);

        $comments = Comment::latest()
                                ->where('feedback_id',$request->feedback_id)
                                ->get();
        return view('frontend.comments.comments',compact('comments'));
    }

    public function updateComment(Request $request)
    {
            $commentValue = $request->comment;
            $commentId = $request->commentId;
            Comment::where('id',$commentId)->update(['body'=>$commentValue]);

            $comments = Comment::with('feedback')->get();
            return view('backend.admin.comment.index',compact('comments'));
    }

    public function deleteComment(Request $request)
    {
        $deleteComment = $request->deleteCommentId;
        Comment::destroy($deleteComment);
        return response()->json(['Message'=>'SuccessFully Delete the Record']);
    }


}
