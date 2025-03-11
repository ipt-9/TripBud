<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use function Laravel\Prompts\error;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:50',
            'username' => 'required|string|max:30|unique:users,username',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('tripbud')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'user' => [
                'full_name' => $user->full_name,
                'username' => $user->username,
                'email' => $user->email,
            ],
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->login)
            ->orWhere('email', $request->login)
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $user->tokens->each(function ($token) {
                $token->delete();
            });

            $token = $user->createToken('tripbud')->plainTextToken;
            session(['auth_token' => $token]);

            return response()->json([
                'message' => 'Login successful',
                'user' => [
                    'full_name' => $user->full_name,
                    'username' => $user->username,
                    'email' => $user->email,
                ],
                'token' => $token,
            ], 200);
        }

        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }

    public function checkAuth()
    {
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout successful',
        ], 200);
    }

}
