<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{

    // public function showLoginForm()
    // {
    //     return view('auth.login');
    // }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $admin = Auth::user();
            $token = $admin->createToken('Admin Token')->plainTextToken; // Use Sanctum for token generation

            return response()->json(['token' => $token, 'admin' => $admin]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}