<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Vote;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    use HelperTrait;
    public function storeVote(Request $request)
    {


        $VoteDatas  = [
            "value"=> $request->currentVote,
            'feedback_id' => $request->feedBackId,
            'user_id'=>Auth::user()->id
        ];

        $vote = Vote::where('value',$request->currentVote)
                    ->where('feedback_id', $request->feedBackId)
                    ->where('user_id',Auth::user()->id)
                    ->exists();
        if ($vote)
        {
            return response()->json(['message'=>'One Vote Per FeedBack'],422);
        }

        else
        {
            $vote = Vote::whereIn('value',[1,2])
                        ->where('feedback_id',$request->feedBackId)
                        ->where('user_id',Auth::user()->id)
                        ->exists();
            if($vote)
            {
                return response()->json(['message'=>'One Vote Per FeedBack'],422);
            }
            else
            {
                $votesId = Vote::create($VoteDatas);
                $this->sendVoteMail($votesId);
                $voteCount = Vote::where('feedback_id',$request->feedBackId)->count();
                return response()->json(['voteId'=>$votesId,'voteCount'=>$voteCount]);
            }

        }

    }
}
