<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function updateUser(Request $request)
    {
        $validateRule = [
            'name' => 'required|string|max:255',
            'email' => ['required',Rule::unique('users')->ignore(Auth::user()->id),],
            'password' => 'nullable|string|min:8',
        ];

        $validatedData = Validator::make($request->all(),$validateRule);

        if($validatedData->fails())
        {
            return response()->json($validatedData->errors(), 422);
        }

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->filled('password')){
            $user->password = Hash::make($request->password);
        }
        $user->save();

    }
}
