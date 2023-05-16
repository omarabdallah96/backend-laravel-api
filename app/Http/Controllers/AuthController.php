<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Auth\Events\Login;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Generate token for the registered user
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful',
            'token' => $token,
            'user' => $user

        ]);
    }

    public function login(LoginRequest $request)
    {



        if (Auth::attempt($request->only('email', 'password'))) {
            // Authentication successful
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user
            ]);
        } else {
            // Authentication failed
            return response()->json(['errors' => ['message' => 'Invalid credentials']], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function checkAuth()
    {
        $user = Auth::user();

        return response()->json([
            'message' => 'User is authenticated',
            'user' => $user,
        ]);
    }
}
