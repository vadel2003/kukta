<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, $next)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        return $next($request);
    }
}
