<?php

namespace App\Http\Controllers;

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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('Personal Access Token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user,
            ]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}

        // if (Auth::attempt($credentials)) {
        //     $user = Auth::user();

        //     // Redirect to admin dashboard or desired page
        //     return redirect()->intended('/admin/dashboard');
        // }

    //     return redirect()->back()->with('error', 'Invalid email or password.');
    // }

