<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;


use Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $rules = [
            'name' => 'unique:users|required',
            'email'    => 'unique:users|required',
            'password' => 'required',
        ];
    
        $input = $request->only('name', 'email','password');
        $validator = Validator::make($input, $rules);
    
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->messages()], 400);
        }
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $user = User::create(['name' => $name, 'email' => $email, 'password' => Hash::make($password)]);
    }

    public function login(Request $request)
    {
        $creds = $request->only(['email', 'password']);
        if(!$token = auth()->attempt($creds))
        {
            return response()->json(['error' => true, 'message' => 'Incorrect login or password'], 401);
        }
        return response()->json(['token' => $token], 200);
    }
}
