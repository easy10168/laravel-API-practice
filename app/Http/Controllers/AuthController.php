<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedRequest = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'unique:users', 'email'],
            'password' => ['required', 'string', 'confirmed']
        ]);

        $user = User::create([
            'name' => $validatedRequest['name'],
            'email' => $validatedRequest['email'],
            'password' => Hash::make($validatedRequest['password']),
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request)
    {
        Auth::user()->tokens()->delete();

        return response([
            'message' => 'Logout Successfully'
        ]);
    }

    public function login(Request $request)
    {
        $validatedRequest = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where([['email', $validatedRequest['email']]])->first();

        if (!$user || !Hash::check($validatedRequest['password'], $user->password)) {
            return response([
                'message' => '該信箱不存在或者密碼錯誤'
            ], 401);
        }
        $user->tokens()->delete();
        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
}
