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
    public function showLoginForm()
    {
        return view('auth.login.');
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('Personal Access Token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user,
            ], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }



    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // public function index()
    // {
    //     return view('admin.dashboard');
    // }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
