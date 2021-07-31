<?php

namespace App\Http\Controllers;

use App\Models\Admin;
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

        $token = $user->createToken('myapptoken', ['role:user'])->plainTextToken;

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
        $token = $user->createToken('myapptoken', ['role:user'])->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function adminRegister(Request $request)
    {
        $validatedRequest = $request->validate([
            'name' => ['required', 'string'],
            'account' => ['required', 'string', 'unique:admins'],
            'password' => ['required', 'string', 'confirmed']
        ]);

        $user = Admin::create([
            'name' => $validatedRequest['name'],
            'account' => $validatedRequest['account'],
            'password' => Hash::make($validatedRequest['password']),
        ]);

        $token = $user->createToken('myapptoken', ['role:admin'])->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function adminLogin(Request $request)
    {
        $validatedRequest = $request->validate([
            'account' => 'required|string',
            'password' => 'required|string'
        ]);

        $admin = Admin::where([['account', $validatedRequest['account']]])->first();

        if (!$admin || !Hash::check($validatedRequest['password'], $admin->password)) {
            return response([
                'message' => '該帳號不存在或者密碼錯誤'
            ], 401);
        }
        $admin->tokens()->delete();
        $token = $admin->createToken('myapptoken', ['role:admin'])->plainTextToken;

        $response = [
            'admin' => $admin,
            'token' => $token
        ];

        return response($response, 201);
    }
}
