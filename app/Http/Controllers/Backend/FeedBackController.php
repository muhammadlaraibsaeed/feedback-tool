<?php

namespace App\Http\Controllers\Backend;

use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FeedBack;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FeedBackController extends Controller
{
    use HelperTrait;

    public function feedstore(Request $request)
    {

       $formData = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $validatedData = Validator::make($request->all(), $formData);


        if($validatedData->fails())
        {
            return response()->json($validatedData->errors(), 422);
        }

        $feedDatas = $request->except('_token');

        if ($request->hasFile('image'))
        {
            $imageName = $this->storeImage($request->image);
            $feedDatas['image'] = $imageName;
        }

        $feedDatas['user_id'] = Auth::user()->id;
        $feedDatas['category_id'] = $request->category;
        FeedBack::create($feedDatas);

        return response()->json(['message'=>'Thank Your for FeedBack']);

    }

    public function deleteFeed(Request $request)
    {
        $feedBackId = $request->feedBackId;
        FeedBack::destroy($feedBackId);
    }

    public function updateFeedBack(Request $request)
    {
        $formData = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $validatedData = Validator::make($request->all(), $formData);

        if($validatedData->fails())
        {
            return response()->json($validatedData->errors(), 422);
        }

        $feedDatas = $request->except('_token','feedback_id','category');

        if ($request->hasFile('image'))
        {
            $imageName = $this->storeImage($request->image);
            $feedDatas['image'] = $imageName;
        }

        $feedDatas['user_id'] = Auth::user()->id;
        $feedDatas['category_id'] = $request->category;

        $feedback_id = $request->feedback_id;

        FeedBack::where('id',$feedback_id)
                   ->update($feedDatas);

        $feedbacks = FeedBack::all();

        return view('backend.admin.feedback.index',compact('feedbacks'));
    }



}
