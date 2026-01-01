<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     * Accepts a comma separated list of allowed role values.
     */
    public function handle(Request $request, Closure $next, string $roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $allowed = array_map('trim', explode(',', $roles));
        if (!in_array((string)Auth::user()->role, $allowed, true)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
