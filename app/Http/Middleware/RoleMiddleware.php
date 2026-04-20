<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Single-role guard, e.g. role:candidate.
 * Do not use a comma inside the parameter (e.g. role:a,b): Laravel splits middleware
 * arguments on commas, so use {@see EnsureUserIsBackOfficeStaff} for admin + super_admin.
 */
class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $roles)
    {
        if (! auth()->check()) {
            abort(403);
        }

        $allowed = array_map('trim', explode(',', $roles));

        if (! in_array(auth()->user()->role, $allowed, true)) {
            abort(403);
        }

        return $next($request);
    }
}