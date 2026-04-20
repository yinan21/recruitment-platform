<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Allows users who may access the admin panel (admin or super_admin).
 * Prefer this over role:admin,super_admin because Laravel splits middleware
 * parameters on commas, which would break a single role parameter containing a comma.
 */
class EnsureUserIsBackOfficeStaff
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->isAdmin()) {
            abort(403);
        }

        return $next($request);
    }
}
