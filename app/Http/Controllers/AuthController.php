<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!auth()->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
                'data' => null,
                'meta' => [
                    'code' => 401
                ]
            ], 401);
        }

        $user = auth()->user();

        if ($user->tokens()->count() > 0) {
            $user->tokens()->delete();
        }

        $userResponse = [
            'name' => $user->name,
            'email' => $user->email,
            'token' => $user->createToken('apptoken', ['*'], now()->addWeek())->plainTextToken
        ];

        return response()->json([
            'success' => true,
            'message' => 'Login success',
            'data' => $userResponse,
            'meta' => [
                'expires_at' => $user->tokens()->first()->expires_at
            ]
        ]);
    }
}
