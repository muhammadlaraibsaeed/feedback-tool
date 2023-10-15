<?php
namespace App\Traits;

use App\Models\Comment;
use App\Mail\CommentMail;
use App\Mail\VoteMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

trait HelperTrait{

    public function storeImage($uploadImage)
    {
        $feedData['image'] = $uploadImage->storeAs('images/report', $uploadImage->getClientOriginalName());
        $uploadImage->move(public_path('images/report'),$feedData['image']);
        return $feedData['image'];
    }


    public function getAuth($feedbacks)
    {
        foreach($feedbacks as $key=>$feedback)
        {
            dump($feedback->votes[0]->user_id);
            if($feedback->vote[$key]->user_id == Auth::user()->id)
            {
                return true;
            }
        }
        return false;
    }

    public function sendCommentMail($comments)
    {
        $comments['send_email'] = Auth::user()->email;
        Mail::to($comments->feedback->user->email)->queue(new CommentMail($comments));
    }

    public function sendVoteMail($votes)
    {
        $votes['send_email'] = Auth::user()->email;
        // email who create feedback
        Mail::to($votes->feedback->user->email)->queue(new VoteMail($votes));
    }

}
