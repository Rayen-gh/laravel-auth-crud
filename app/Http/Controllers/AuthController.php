<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
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
         $request->validate([
            'email' => 'required|string|email|max:255|exists:users',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();
        if( !$user || !Hash::check($request->password, $user->password)){
            return response([
                'message' => 'user not found or password is incorrect'
            ], 401);
        }

        $token = $user->createToken($user->name);
        return [
            'user' => $user,
            'token' => $token->plainTextToken,
            'message' => 'user logged in successfully',
        ];
    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return [
            'message' => 'user logged out successfully',
        ];
    }
}
