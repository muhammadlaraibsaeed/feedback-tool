<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FeedBack;
use Illuminate\Http\Request;
use App\Models\Vote;
use App\Traits\HelperTrait;
use Illuminate\Support\Facades\Auth;

class FeedBackController extends Controller
{

    use HelperTrait;

    public function feedList(Request $request)
    {

        if($request->ajax())
        {
           $found = FeedBack::where('category_id',$request->category_id)->exists();

           if(empty($found))
           {
                return response()->json(['category'=>"Not Found"],404);
           }
        else
        {

                $feedBacks = FeedBack::withCount('votes')
                ->with('votes')
                ->with('category')
                ->when($request->filled('category_id'), function ($query) use ($request) {
                    $query->orderByRaw("FIELD(category_id, ?) {$request->sort}", [$request->category_id]);
                })
                ->orderBy('category_id')
                ->paginate(10);
                $co_votes = Vote::where('user_id',Auth::user()->id)->get();
                return view('frontend.feedback.partials.list',compact('feedBacks','co_votes'));
           }

        }else{

            $feedBacks = FeedBack::withCount('votes')
            ->with('votes')
            ->paginate(10);
            $categories = Category::all();
            $co_votes = Vote::where('user_id',Auth::user()->id)->get();

            return view('frontend.feedback.list',compact('feedBacks','categories','co_votes'));
        }



    }


    public function feedForm()
    {
        $categories = Category::all();
        return view('frontend.feedback.form',compact('categories'));
    }

}
