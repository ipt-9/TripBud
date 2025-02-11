<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:50',
            'username' => 'required|string|max:30|unique:users,username',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $encryptedFullName = Crypt::encryptString($request->full_name);
        $encryptedUsername = Crypt::encryptString($request->username);
        $encryptedEmail = Crypt::encryptString($request->email);
        $encryptedPassword = Crypt::encryptString($request->password);
        $hashedPassword = Hash::make($encryptedPassword);

        $user = User::create([
            'full_name' => $encryptedFullName,
            'username' => $encryptedUsername,
            'email' => $encryptedEmail,
            'password' => $hashedPassword,
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        $encryptedIdentifier = Crypt::encryptString($request->identifier);

        $user = User::where('username', $encryptedIdentifier)
            ->orWhere('email', $encryptedIdentifier)
            ->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $encryptedPassword = Crypt::encryptString($request->password);

        if (!Hash::check($encryptedPassword, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user
        ]);
    }
    public function checkAuth()
    {
    }
    public function logout()
    {
    }
}
