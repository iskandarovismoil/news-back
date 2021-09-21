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
            return response()->json(['success' => false, 'error' => $validator->messages()], 200);
        }
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $repassword = $request->repassword;

        if($password != $repassword)
            return response()->json(['success' => false, 'error' => 'Пароли не совпадают !'], 200);

        $user = User::create(['name' => $name, 'email' => $email, 'password' => Hash::make($password)]);
        return response()->json(['success' => true, 'error' => false], 200);
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

    public function user($id)
    {   
        $user = User::where([['id', $id]])->first();
        
        return response()->json(['data' => $user], 200);
    }

    
}
