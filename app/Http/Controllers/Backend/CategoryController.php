<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function storeCategory(Request $request)
    {
        $validateData =
        [
            'body' => [
            'required',
            Rule::unique('categories')->ignore($request->id),]
        ];
        $validatedData = Validator::make($request->all(),$validateData);

        if($validatedData->fails())
        {
            return response()->json($validatedData->errors(), 422);
        }

        $category = Category::create($request->all());
        return response()->json(['category'=>"Successfully Added ".$category->body]);
    }


    public function updateCategory(Request $request)
    {
        $categoryName = $request->category;
        $categoryId = $request->categoryId;
        Category::where('id',$categoryId)->update(['body'=>$categoryName]);

        $categories = Category::all();

        return view('backend.admin.category.index',compact('categories'));

    }

    public function deleteCategory(Request $request)
    {
        $categoryId = $request->categoryId;
        Category::destroy($categoryId);

        return response()->json(['message'=>'Successfully Deleted']);
    }

}
