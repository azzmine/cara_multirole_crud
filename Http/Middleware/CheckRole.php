<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Cek apakah user punya relasi role
        if (!Auth::user()->role) {
            Auth::logout();
            return redirect('/login')->with('error', 'User tidak memiliki role');
        }

        // Cek apakah role sesuai
        if (Auth::user()->role->name !== $role) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
