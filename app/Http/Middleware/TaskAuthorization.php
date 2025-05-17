<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskAuthorization
{
    public function handle(Request $request, Closure $next, string $ability)
    {
        if (!Auth::user()->can($ability . ' task')) {
            abort(403);
        }

        return $next($request);
    }
} 