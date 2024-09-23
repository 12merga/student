<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        $role = 'admin'; // Define the role name
        $roleId = Role::where('name', $role)->value('id');        

        if (Auth::user()->role_id !== $roleId) {
            return redirect('/'); // Redirect to home if user doesn't have the right role
        }

        return $next($request);
    }
}
