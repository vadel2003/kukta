<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Only the super admin can open the admin pages, others get a 403 error.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        return $next($request);
    }
}
