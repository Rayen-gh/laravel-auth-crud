<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request){
        
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
        ]);
        $fields['password'] = bcrypt($fields['password']);

        $user = User::create($fields);

        $token = $user->createToken($request->name);
         
        return [
            'user' => $user,
            'token' => $token->plainTextToken,
            'message' => 'user created successfully',

            
            ] ;


    }

    public function login(Request $request){
        return 'login' ;
    }

    public function logout(Request $request){
        return 'logout' ;
    }
}
