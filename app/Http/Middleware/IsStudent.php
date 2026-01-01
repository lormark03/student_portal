<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsStudent
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== \App\Models\User::ROLE_STUDENT) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
