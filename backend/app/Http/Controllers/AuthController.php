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

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Login successful',
                    'user' => [
                        'full_name' => $user->full_name,
                        'username' => $user->username,
                        'email' => $user->email,
                    ],
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Incorrect password',
                ], 401);
            }
        }

        return response()->json([
            'message' => 'User not found',
        ], 404);
    }


    public function checkAuth()
    {
    }
    public function logout()
    {
    }
}
