<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class IsAdminOrInstructor
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user) {
            abort(403);
        }

        if (in_array($user->role, [
            User::ROLE_ADMIN,
            User::ROLE_INSTRUCTOR
        ])) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
